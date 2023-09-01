<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            ['name' => 'planeamento', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'professor', 'created_at' => now(), 'updated_at' => now(),],
        ]);
    }
}
