<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 'br10',
            'name' => 'Bart Roos',
            'email' => 'test@amo.com',
            'password' => bcrypt('test34'),
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
            'user_id' => 'br10'
        ]);
    }
}
