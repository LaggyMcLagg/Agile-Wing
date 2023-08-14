<?php

use Illuminate\Database\Seeder;
use App\CourseClass;

class CourseClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CourseClass::class, 15)->create();
    }
}
