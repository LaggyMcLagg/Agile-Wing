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
        for ($i = 1; $i <= 50; $i++) {
            $y= random_int(1, 5);
            for ($j=1; $j <= 4; $j++) { 
                DB::table('teacher_availabilities')->insert([
                    'availability_date' => Carbon::now()->addDay(),
                    'is_locked' => true,
                    'user_id' => $i+2,
                    'hour_block_id' => $y,
                    'availability_type_id' => random_int(1, 4),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $y++;
            }
        }
    }
}
