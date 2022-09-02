<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kid;
use Faker\Generator as Faker;

$factory->define(Kid::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'desc' => $faker->words(10, true),
    ];
});
