<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teacherGroup = new Group();
        $teacherGroup->name = 'docenten';
        $teacherGroup->type = 'group';
        $teacherGroup->date_start = '2017-08-01';
        $teacherGroup->date_end = '9999-12-12';
        $teacherGroup->save();

        $teacher = User::factory()->create([
            'id' => 'xy10',
            'name' => 'Test Kees',
            'email' => 'kees@curio.codes',
            'type' => 'teacher',
        ]);

        $teacherGroup->users()->attach($teacher);

        $studentGroup = new Group();
        $studentGroup->name = 'studenten';
        $studentGroup->type = 'group';
        $studentGroup->date_start = '2017-08-01';
        $studentGroup->date_end = '9999-12-12';
        $studentGroup->save();

        $student = User::factory()->create([
            'id' => 'i123456',
            'name' => 'Test Piet',
            'email' => 'piet@curio.codes',
            'type' => 'student',
        ]);

        $studentGroup->users()->attach($student);
    }
}
