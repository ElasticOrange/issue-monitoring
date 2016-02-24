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
        'password' => bcrypt($pass),
        'remember_token' => $pass,
        'active' => true,
        'type' => 'client',
    ];
});

$factory->define(Issue\FlowStep::class, function (Faker\Generator $faker) {
    return [
		'flow_name' => $faker->name,
		'estimated_duration' => $faker->randomNumber,
		'location_step_id' => $faker->randomNumber,
		'flowstep_order' => $faker->randomNumber,
		'start_date' => $faker->date,
		'end_date' => $faker->date,
		'ro.observatii' => "ro".$faker->name,
		'en.observatii' => "en".$faker->name,
    ];
});

$factory->define(Issue\LocationStep::class, function (Faker\Generator $faker) {
    return [
		'location_id' => $faker->randomDigit,
		'issue_id' 	  => $faker->randomNumber,
		'step_order'  => $faker->randomNumber,
		'flowsteps'   => factory(Issue\FlowStep::class, 3)->create(),
    ];
});

$factory->define(Issue\UploadedFile::class, function (Faker\Generator $faker) {
    return [
        'file_name' => $faker->name,
        'folder' => '/documents/',
        'original_file_name' => $faker->sentence,
    ];
});

$factory->define(Issue\Document::class, function (Faker\Generator $faker) {
    return [
        'public' => 1,
        'uploaded_file_id' => $faker->randomDigit,
        'public_code' => str_random(40),
        'init_at' => $faker->date,
        'ro.title' => $faker->sentence,
		'en.title' => $faker->sentence,
    ];
});
