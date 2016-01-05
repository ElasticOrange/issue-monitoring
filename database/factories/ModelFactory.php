<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Issue\User::class, function (Faker\Generator $faker) {
    $pass = str_random(10);
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' =>bcrypt($pass),
        'remember_token' => $pass,
    ];
});
