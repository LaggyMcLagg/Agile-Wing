<?php

use Illuminate\Database\Seeder;
use App\User;
use App\ScheduleAtribution;

class ScheduleAtributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            // For each user, create 10 schedule attributions
            factory(ScheduleAtribution::class, 10)->create(['user_id' => $user->id]);
        });
    }
}
