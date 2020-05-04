<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourseItem;
use Faker\Generator as Faker;

$factory->define(CourseItem::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "video_path" => \Illuminate\Support\Str::random(20),
        "audio_path" => \Illuminate\Support\Str::random(20),
        "model_path" => \Illuminate\Support\Str::random(20),
        "content" => \Illuminate\Support\Str::random(20),
        "updated_at" => $faker->dateTime,
        "created_at" => $faker->dateTime,
    ];
});
