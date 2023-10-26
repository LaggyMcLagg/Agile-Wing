<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call(UserTypeSeeder::class);
       $this->call(UserSeeder::class);
       $this->call(HourBlockSeeder::class);
       $this->call(AvailabilityTypeSeeder::class);
       $this->call(TeacherAvailabilitySeeder::class);
       $this->call(SpecializationAreaSeeder::class);
       $this->call(CourseSeeder::class);
       $this->call(CourseClassSeeder::class);
       $this->call(PedagogicalGroupSeeder::class);
       $this->call(PedagogicalGroupUserSeeder::class);
       $this->call(UfcdSeeder::class);
       $this->call(UserUfcdSeeder::class);
       $this->call(CourseUfcdSeeder::class);
       $this->call(HourBlockCourseClassSeeder::class);
       $this->call(ScheduleAtributionSeeder::class);
       $this->call(SpecializationAreaUserSeeder::class);
    }
}
