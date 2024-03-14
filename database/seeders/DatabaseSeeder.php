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

        $teacher = new User();
        $teacher->id = 'xy10';
        $teacher->name = 'Test Kees';
        $teacher->email = 'kees@curio.codes';
        $teacher->password = bcrypt('password');
        $teacher->type = 'teacher';
        $teacher->save();

        $teacherGroup->users()->attach($teacher);

        $studentGroup = new Group();
        $studentGroup->name = 'studenten';
        $studentGroup->type = 'group';
        $studentGroup->date_start = '2017-08-01';
        $studentGroup->date_end = '9999-12-12';
        $studentGroup->save();

        $student = new User();
        $student->id = 'i123456';
        $student->name = 'Test Piet';
        $student->email = 'piet@curio.codes';
        $student->password = bcrypt('password');
        $student->type = 'student';
        $student->save();

        $studentGroup->users()->attach($student);
    }
}
