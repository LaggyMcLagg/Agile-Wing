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

    return [
        'name'             => $name,
        'email'            => $email,
        'password'         => bcrypt('password'),
        'user_type_id'     => 2,
        'token_password'   => bcrypt(Str::random(10)),
        'token_used'       => true,
        'token_created_at' => now(),
        'notes'            => $faker->paragraph,
        'last_login'       => now(),
        'created_at'       => now(),
        'updated_at'       => now(),
        //'email_verified_at'=> now(), se quisermos ter os emails existentes ja verificados
    ];
});
