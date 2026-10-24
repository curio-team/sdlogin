<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Teachers may manage students, but must not be able to take over (or create) teacher and admin accounts.
 */
class UserManagementAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function newUserPayload(string $type): array
    {
        return [
            'type' => $type,
            'id' => 'new01',
            'name' => 'New User',
            'password' => 'temporary-password',
            'password_confirmation' => 'temporary-password',
        ];
    }

    private function passwordResetPayload(): array
    {
        return [
            'name' => 'Renamed',
            'password' => 'taken-over',
            'password_confirmation' => 'taken-over',
        ];
    }

    #[Test]
    public function teacher_cannot_create_an_admin(): void
    {
        $teacher = $this->getTestTeacher();

        $response = $this->actingAs($teacher)->post(route('users.store'), $this->newUserPayload('admin'));

        $response->assertSessionHasErrors('type');
        $this->assertDatabaseMissing('users', ['id' => 'new01']);
    }

    #[Test]
    public function teacher_can_create_students_and_teachers(): void
    {
        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)
            ->post(route('users.store'), $this->newUserPayload('student'))
            ->assertRedirect('/users');

        $this->actingAs($teacher)
            ->post(route('users.store'), ['id' => 'new02'] + $this->newUserPayload('teacher'))
            ->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['id' => 'new01', 'type' => 'student']);
        $this->assertDatabaseHas('users', ['id' => 'new02', 'type' => 'teacher']);
    }

    #[Test]
    public function admin_can_create_an_admin(): void
    {
        $admin = $this->getTestAdmin();

        $this->actingAs($admin)
            ->post(route('users.store'), $this->newUserPayload('admin'))
            ->assertRedirect('/users');

        $this->assertDatabaseHas('users', ['id' => 'new01', 'type' => 'admin']);
    }

    #[Test]
    public function create_form_only_offers_the_admin_type_to_admins(): void
    {
        $this->actingAs($this->getTestTeacher())
            ->get(route('users.create'))
            ->assertOk()
            ->assertDontSee('value="admin"', false);

        $this->actingAs($this->getTestAdmin())
            ->get(route('users.create'))
            ->assertOk()
            ->assertSee('value="admin"', false);
    }

    #[Test]
    public function teacher_cannot_reset_an_admins_password(): void
    {
        $teacher = $this->getTestTeacher();
        $admin = $this->getTestAdmin();

        $this->actingAs($teacher)->get(route('users.edit', $admin))->assertForbidden();
        $this->actingAs($teacher)->put(route('users.update', $admin), $this->passwordResetPayload())->assertForbidden();

        $admin->refresh();
        $this->assertTrue(Hash::check('password', $admin->password));
        $this->assertNotEquals('Renamed', $admin->name);
    }

    #[Test]
    public function teacher_cannot_reset_another_teachers_password(): void
    {
        $teacher = $this->getTestTeacher();
        $colleague = $this->getTestTeacher('zz11');

        $this->actingAs($teacher)->get(route('users.edit', $colleague))->assertForbidden();
        $this->actingAs($teacher)->put(route('users.update', $colleague), $this->passwordResetPayload())->assertForbidden();

        $this->assertTrue(Hash::check('password', $colleague->refresh()->password));
    }

    #[Test]
    public function teacher_can_reset_a_students_password(): void
    {
        $teacher = $this->getTestTeacher();
        $student = $this->getTestStudent();

        $this->actingAs($teacher)->get(route('users.edit', $student))->assertOk();
        $this->actingAs($teacher)
            ->put(route('users.update', $student), $this->passwordResetPayload())
            ->assertRedirect('/users');

        $student->refresh();
        $this->assertTrue(Hash::check('taken-over', $student->password));
        $this->assertNotNull($student->password_force_change);
    }

    #[Test]
    public function admin_can_reset_a_teachers_password(): void
    {
        $admin = $this->getTestAdmin();
        $teacher = $this->getTestTeacher();

        $this->actingAs($admin)
            ->put(route('users.update', $teacher), $this->passwordResetPayload())
            ->assertRedirect('/users');

        $this->assertTrue(Hash::check('taken-over', $teacher->refresh()->password));
    }

    #[Test]
    public function user_index_page_size_is_capped(): void
    {
        $response = $this->actingAs($this->getTestTeacher())->get(route('users.index', ['n' => 1000000]));

        $response->assertOk();
        $this->assertEquals(100, $response->viewData('users')->perPage());
    }

    #[Test]
    public function can_manage_follows_the_role_hierarchy(): void
    {
        $student = new User(['name' => 'Student']);
        $student->type = 'student';
        $teacher = new User(['name' => 'Teacher']);
        $teacher->type = 'teacher';
        $admin = new User(['name' => 'Admin']);
        $admin->type = 'admin';

        $this->assertFalse($student->canManage($student));
        $this->assertTrue($teacher->canManage($student));
        $this->assertFalse($teacher->canManage($teacher));
        $this->assertFalse($teacher->canManage($admin));
        $this->assertTrue($admin->canManage($student));
        $this->assertTrue($admin->canManage($teacher));
        $this->assertTrue($admin->canManage($admin));
    }
}
