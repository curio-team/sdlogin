<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_login_as_student(): void
    {
        $this->seed();

        $this->assertGuest();

        $user = $this->getTestStudent();

        $this->post(route('login.submit'), [
            'id' => 'i000123',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function user_can_login_as_teacher(): void
    {
        $this->seed();

        $this->assertGuest();

        $user = $this->getTestTeacher();

        $this->post(route('login.submit'), [
            'id' => 'izz10',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function student_can_not_access_admin_dashboards(): void
    {
        $this->seed();

        $user = $this->getTestStudent();

        $this->assertGuest();

        $this->actingAs($user)
            ->get('/');

        $this->assertAuthenticatedAs($user);

        $app = $this->getTestClientApp();

        $response = $this->get(route('clients.index'));
        $response->assertDontSeeText($app->name);

        $response = $this->get(route('clients.show', 1));
        $response->assertDontSeeText($app->name);

        $response = $this->get(route('users.import'));
        $response->assertSessionHas('error', 'Geen toegang voor studenten.');

        $response = $this->get(route('users.cleanup'));
        $response->assertSessionHas('error', 'Geen toegang voor studenten.');

        $response = $this->get(route('home'));
        $response->assertSessionDoesntHaveErrors();
    }

    /**
     * @test
     */
    public function teacher_can_access_admin_dashboards(): void
    {
        $this->seed();

        $user = $this->getTestTeacher();

        $this->assertGuest();

        $this->actingAs($user)
            ->get('/');

        $this->assertAuthenticatedAs($user);

        $app = $this->getTestClientApp();

        $response = $this->get(route('clients.index'));
        $response->assertSeeText($app->name);

        $response = $this->get(route('clients.show', 1));
        $response->assertSeeText($app->name);

        $response = $this->get(route('users.import'));
        $response->assertSessionDoesntHaveErrors();

        $response = $this->get(route('users.cleanup'));
        $response->assertSessionDoesntHaveErrors();

        $response = $this->get(route('home'));
        $response->assertSessionDoesntHaveErrors();
    }
}
