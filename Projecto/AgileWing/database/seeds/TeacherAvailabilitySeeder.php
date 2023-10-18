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
        $this->insertTeacherAvailability(1, 1, 1);
    }

    private function insertTeacherAvailability($user, $day, $hourBlock)
    {
        // Base case for user
        if ($user > 50) {
            return;
        }

        // Base case for day
        if ($day > 30) {
            $this->insertTeacherAvailability($user + 1, 1, 1);
            return;
        }

        // Base case for hourBlock
        if ($hourBlock > 4) {
            $this->insertTeacherAvailability($user, $day + 1, 1);
            return;
        }

        $y = $hourBlock + random_int(1, 5) - 1;  // Modified calculation for y
        DB::table('teacher_availabilities')->insert([
            'availability_date'     => Carbon::now()->addDay($day),
            'is_locked'             => true,
            'user_id'               => $user + 2,
            'hour_block_id'         => $y,
            'availability_type_id'  => random_int(1, 4),
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        // Recursive call for the next hour block
        $this->insertTeacherAvailability($user, $day, $hourBlock + 1);
    }
}
