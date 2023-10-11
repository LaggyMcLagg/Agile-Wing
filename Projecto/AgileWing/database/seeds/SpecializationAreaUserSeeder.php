<?php

use Illuminate\Database\Seeder;
use App\User;
use App\SpecializationArea;

class SpecializationAreaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all users
        $users = User::all();

        // Retrieve all specialization areas
        $specializationAreas = SpecializationArea::all();

        // Iterate over each user
        foreach ($users as $user) {
            // Get 2 random specialization areas without duplicates
            $randomSpecializationAreas = $specializationAreas->random(2);

            // Attach the random specialization areas to the user
            foreach ($randomSpecializationAreas as $specializationArea) {
                DB::table('specialization_area_users')->insert([
                    'specialization_area_number' => $specializationArea->number,
                    'user_id'       => $user->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }
}
