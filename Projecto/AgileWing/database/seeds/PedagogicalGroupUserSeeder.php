<?php

use Illuminate\Database\Seeder;
use App\User;
use App\PedagogicalGroup;

class PedagogicalGroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all pedagogical groups
        $groups = PedagogicalGroup::all();

        // Iterate over all users
        User::all()->each(function ($user) use ($groups) {
            // Attach two random groups to each user
            $user->pedagogicalGroups()->attach(
                $groups->random(2)->pluck('id')->toArray(),
                ['created_at' => now(), 'updated_at' => now()]
            );
        });
    }
}
