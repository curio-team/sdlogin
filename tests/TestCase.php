<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Client;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getTestStudent($id = '000123', $password = 'password'): User
    {
        return User::factory()->create([
            'id' => "i$id",
            'email' => "d$id@curio.codes",
            'password' => bcrypt($password),
            'type' => 'student',
        ]);
    }

    protected function getTestStudents($count = 5): array
    {
        $students = [];
        for ($i = 0; $i < $count; $i++) {
            $students[] = $this->getTestStudent("000$i");
        }
        return $students;
    }

    protected function getTestTeacher($id = 'zz10', $password = 'password'): User
    {
        return User::factory()->create([
            'id' => "i$id",
            'email' => "$id@curio.codes",
            'password' => bcrypt($password),
            'type' => 'teacher',
        ]);
    }

    protected function getTestClientApp($name = 'Test App', $redirect = 'https://test.app', $forDevelopment = true): Client
    {
        return Client::factory()->create([
            'name' => $name,
            'redirect' => $redirect,
            'for_development' => $forDevelopment,
        ]);
    }
}
