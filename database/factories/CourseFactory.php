<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'description'=> \Illuminate\Support\Str::random(30),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});
