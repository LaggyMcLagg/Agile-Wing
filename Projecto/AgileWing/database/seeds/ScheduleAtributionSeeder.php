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

        User::where('user_type_id', '<>', 2)->get()->each(function ($user) {
            factory(ScheduleAtribution::class, 30)->create(['user_id' => $user->id]);
        });
        
    }
}
