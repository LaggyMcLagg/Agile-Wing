<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $name = $faker->firstName . ' ' . $faker->lastName;
    $email = Str::lower(str_replace(' ', '.', $name)) . '@edu.atec.pt';
    $randomColor = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);

    return [
        'name'             => $name,
        'email'            => $email,
        'password'         => bcrypt('password'),
        'email_verified_at' => now(), 
        'user_type_id'     => 2,
        'token_password'   => bcrypt(Str::random(10)),
        'token_created_at' => now(),
        'color_1'          => $randomColor,
        'notes'            => $faker->paragraph,
        'last_login'       => now(),
        'created_at'       => now(),
        'updated_at'       => now(),
    ];
});
