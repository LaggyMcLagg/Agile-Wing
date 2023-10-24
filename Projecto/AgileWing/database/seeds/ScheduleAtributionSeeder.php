<?php

use Illuminate\Database\Seeder;
use App\User;
use App\ScheduleAtribution;
use Carbon\Carbon;  // Import Carbon for date manipulation.

class ScheduleAtributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::where('user_type_id', 2)->get()->each(function ($user) {
            foreach (range(1, 10) as $i) {
                factory(ScheduleAtribution::class)->create(
                    [
                        'date' => Carbon::now()->addDays($i)->format('Y-m-d'),
                        'user_id' => $user->id,
                    ]
                );
            }
        });
    }
}
