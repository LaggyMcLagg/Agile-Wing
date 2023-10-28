<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TeacherAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertTeacherAvailability(1, 1);
    }

    private function insertTeacherAvailability($user, $day)
    {
        // Base case for user
        if ($user > 50) {
            return;
        }

        // Base case for day
        if ($day > 30) {
            $this->insertTeacherAvailability($user + 1, 1);
            return;
        }

        // $i= random_int(1, 5);
        for ($j=1; $j <= 9; $j++) { 
            DB::table('teacher_availabilities')->insert([
                'availability_date'     => Carbon::now()->addDay($day),                
                'is_locked'             => false,
                'user_id'               => $user+2,
                'hour_block_id'         => $j,
                'availability_type_id'  => random_int(1, 4),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
            // $i++;
        }

        // Recursive call for the next day
        $this->insertTeacherAvailability($user, $day +1);
    }
}
