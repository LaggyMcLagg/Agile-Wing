<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseClass;
use App\Course;
use Faker\Generator as Faker;

$factory->define(CourseClass::class, function (Faker $faker) {

    // Get a random course
    $course = Course::inRandomOrder()->first();
    
    // Generate a random number between 1 and 12
    $firstPart = $faker->numberBetween(1, 12);
    
    // Select either 23 or 24 for the second part
    $secondPart = $faker->numberBetween(23, 24);
    
    // Combine the two parts with a point to create the required number
    $number = ($firstPart < 10 ? '0' . $firstPart : $firstPart) . '.' . $secondPart;
    
    return [
        'name'      => $course->initials,
        'number'    => $number,
        'course_id' => $course->id,
    ];

});
