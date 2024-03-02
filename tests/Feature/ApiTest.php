<?php

namespace Tests\Feature;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_should_redirect_when_not_logged_in()
    {
        $this->seed();

        $response = $this->get(route('api.groups'));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function it_should_return_all_groups_when_logged_in()
    {
        $this->seed();

        $group = Group::factory()->create();

        Passport::actingAs(
            $this->getTestStudent(),
            []
        );

        $response = $this->get(route('api.groups'));

        $response->assertStatus(200);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->each(
                fn (AssertableJson $jsonItem) =>
                $jsonItem->missing('users')
                    ->hasAll(['id', 'name', 'date_start', 'date_end'])
                    ->etc()
            )
        );
    }

    /**
     * @test
     */
    public function it_should_return_a_group_with_users_for_teachers()
    {
        $this->seed();

        // Create a group with students
        $group = Group::factory()->create();
        $students = collect($this->getTestStudents(5));
        $group->users()->attach($students->pluck('id')->toArray());

        Passport::actingAs(
            $this->getTestTeacher(),
            []
        );

        $response = $this->get(route('api.groups.group', $group));

        $response->assertStatus(200);

        // Ensure there's users, but not their (hashed) passwords
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has(
                'users',
                fn (AssertableJson $jsonItem) =>
                $jsonItem->count($students->count())
                    ->each(
                        fn (AssertableJson $jsonItem) =>
                        $jsonItem->hasAll(['id', 'name', 'email', 'type'])
                            ->missing('password')
                            ->etc()
                    )
            )
                ->etc()
        );
    }

    /**
     * @test
     */
    public function it_should_return_a_group_with_user_ids_only_for_students()
    {
        $this->seed();

        // Create a group with students
        $group = Group::factory()->create();
        $students = collect($this->getTestStudents(5));
        $group->users()->attach($students->pluck('id')->toArray());

        Passport::actingAs(
            $this->getTestStudent(),
            []
        );

        $response = $this->get(route('api.groups.group', $group));

        $response->assertStatus(200);

        // Ensure there's only id's of users
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has(
                'users',
                fn (AssertableJson $jsonItem) =>
                $jsonItem->count($students->count())
                    ->each(
                        fn (AssertableJson $jsonItem) =>
                        $jsonItem->has('id')
                            ->missingAll(['name', 'email', 'type', 'password'])
                            ->etc()
                    )
            )
                ->etc()
        );
    }
}
