<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Ufcd;

class UserUfcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        // Iterate over all users
        User::all()->each(function ($user) {
            $userPedagogicalGroupIds = $user->pedagogicalGroups->pluck('id');

            // Get all the matching UFCDS for the user
            $ufcds = Ufcd::whereIn('pedagogical_group_id', $userPedagogicalGroupIds)->get();

            // Determine the count to attach, either 2 or the available count
            $countToAttach = min($ufcds->count(), 2);

            // Attach the random UFCDS to the user
            $user->ufcds()->attach(
                $ufcds->random($countToAttach)->pluck('id')->toArray(),
                ['created_at' => now(), 'updated_at' => now()]
            );
        });
    }
}
