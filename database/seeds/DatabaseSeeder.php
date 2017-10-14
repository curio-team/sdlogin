<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
        ]);

        DB::table('users')->insert([
            'name' => 'test212',
            'email' => 'test@amo.com',
            'password' => bcrypt('test34'),
            'asset_type' => 'teacher',
            'asset_id' => 1
        ]);
    }
}
