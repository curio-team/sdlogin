<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 'xy10',
            'name' => 'Test Kees',
            'email' => 'test@curio.codes',
            'password' => bcrypt('password'),
            'type' => 'teacher',
        ]);

        DB::table('groups')->insert([
            'name' => 'docenten',
            'type' => 'group',
            'date_start' => '2017-08-01',
            'date_end' => '9999-12-12'
        ]);

        DB::table('group_user')->insert([
            'group_id' => 1,
            'user_id' => 'xy10'
        ]);
    }
}
