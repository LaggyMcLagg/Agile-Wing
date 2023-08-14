<?php

/**
 * Generates a random time between the specified start and end times.
 *
 * @param string $start The starting time in 'H:i' format.
 * @param string $end The ending time in 'H:i' format.
 * @return string The randomly generated time in 'H:i' format.
 */
function randomTime($start, $end) {
    $startTimestamp = strtotime($start);
    $endTimestamp = strtotime($end);

    // Calculate the number of 15-minute intervals between the start and end timestamps
    $intervals = ($endTimestamp - $startTimestamp) / (15 * 60);

    // Choose a random interval
    $randomInterval = mt_rand(0, $intervals - 1);

    // Calculate the random timestamp using the selected interval
    $randomTimestamp = $startTimestamp + ($randomInterval * 15 * 60);

    return date('H:i', $randomTimestamp);
}

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\ScheduleAtribution;
use App\AvailabilityType;
use App\CourseClass;
use App\Ufcd;
use App\User;

$factory->define(ScheduleAtribution::class, function (Faker $faker) {
    $hourStart = randomTime('08:15', '21:15');
    $hourEnd = date('H:i', strtotime($hourStart . ' +2 hours'));
    
    return [
        'date' => $faker->dateTimeBetween('tomorrow', '+10 days'),
        'hour_start' => $hourStart,
        'hour_end' => $hourEnd,
        'availability_type_id' => $faker->numberBetween(2, 3),
        'course_class_id' => CourseClass::all()->random()->id,
        'ufcd_id' => Ufcd::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];

});