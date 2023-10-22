<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\ScheduleAtribution;
use App\HourBlockCourseClass;
use App\CourseClass;
use App\Ufcd;
use App\User;

$factory->define(ScheduleAtribution::class, function (Faker $faker) {
    // Selects a random CourseClass
    $courseClass = CourseClass::all()->random();
    $courseId = $courseClass->course_id;

    // Selects a random hour block that belongs to the selected courseClass.
    $hourBlockCourseClass = HourBlockCourseClass::where('course_class_id', $courseClass->id)->get()->random();

    // Selects an UFCD that's associated with the same course.
    $ufcd = $courseClass->course->ufcds->random();

    return [
        'date' => $faker->dateTimeBetween('tomorrow', '+10 days'),
        'hour_block_course_class_id' => $hourBlockCourseClass->id,
        'availability_type_id' => rand(2, 3),
        'course_class_id' => $courseClass->id,
        'ufcd_id' => $ufcd->id,
    ];
});
