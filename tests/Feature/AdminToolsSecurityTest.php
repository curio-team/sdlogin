<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminToolsSecurityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function group_password_reset_generates_temporary_passwords(): void
    {
        $group = Group::factory()->create();
        $students = collect($this->getTestStudents(5));
        $group->users()->attach($students->pluck('id')->toArray());

        $response = $this->actingAs($this->getTestAdmin())->post('/grouplogin/' . $group->id);

        $response->assertOk();
        $printed = collect($response->viewData('userprint'))->keyBy('id');

        foreach ($students as $student) {
            $student->refresh();
            $password = $printed[$student->id]['pass'];

            $this->assertEquals(6, strlen($password));
            $this->assertTrue(Hash::check($password, $student->password));
            $this->assertNotNull($student->password_force_change, 'Printed passwords must be changed on first login');
        }
    }

    #[Test]
    public function teacher_cannot_reset_group_passwords(): void
    {
        $group = Group::factory()->create();

        $this->actingAs($this->getTestTeacher())
            ->post('/grouplogin/' . $group->id)
            ->assertForbidden();
    }

    public static function unsafeUrls(): array
    {
        return [
            'data' => ['data://text/html,hello'],
            'javascript' => ['javascript:alert(1)'],
            'view-source' => ['view-source://example.com'],
            'file' => ['file:///etc/passwd'],
        ];
    }

    #[Test]
    #[DataProvider('unsafeUrls')]
    public function links_only_accept_http_urls(string $url): void
    {
        $teacher = $this->getTestTeacher();

        $this->actingAs($teacher)
            ->post(route('links.store'), ['short' => 'BAD', 'url' => $url])
            ->assertSessionHasErrors('url');

        $this->assertDatabaseMissing('links', ['short' => 'BAD']);

        $link = new Link();
        $link->short = 'OK';
        $link->url = 'https://example.com';
        $link->on_frontpage = false;
        $link->creator = $teacher->id;
        $link->save();

        $this->actingAs($teacher)
            ->put(route('links.update', $link), ['url' => $url])
            ->assertSessionHasErrors('url');

        $this->assertEquals('https://example.com', $link->refresh()->url);
    }

    #[Test]
    public function links_accept_https_urls(): void
    {
        $this->actingAs($this->getTestTeacher())
            ->post(route('links.store'), ['short' => 'GOOD', 'url' => 'https://example.com/page'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('links', ['short' => 'GOOD']);
    }

    #[Test]
    public function client_dev_flag_cannot_be_toggled_with_a_get_request(): void
    {
        $client = $this->getTestClientApp(forDevelopment: false);

        $admin = $this->getTestAdmin();

        $this->actingAs($admin)
            ->get('/clients/' . $client->getKey() . '/toggle')
            ->assertMethodNotAllowed();
        $this->assertFalse((bool) $client->refresh()->for_development);

        $this->actingAs($admin)
            ->post(route('clients.toggle-dev', $client))
            ->assertRedirect();
        $this->assertTrue((bool) $client->refresh()->for_development);
    }
}
