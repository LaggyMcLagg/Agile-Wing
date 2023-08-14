<?php

use Illuminate\Database\Seeder;
use App\Ufcd;
use App\Course;

class CourseUfcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all UFCDs
        $allUfcds = Ufcd::all();

        // Iterate over all courses
        Course::all()->each(function ($course) use ($allUfcds) {
            // Attach 10 random UFCDs to each course
            $course->ufcds()->attach(
                $allUfcds->random(10)->pluck('id')->toArray(),
                ['created_at' => now(), 'updated_at' => now()]
            );
        });
    }
}
