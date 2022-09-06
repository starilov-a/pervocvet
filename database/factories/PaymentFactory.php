<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'desc' => $faker->sentence(rand(1,10)),
        'payment' => $faker->numberBetween(10000, 40000),
        'kid_id' => \App\Kid::inRandomOrder()->limit('1')->get()[0]->id,
        'classroom_id' => \App\Classroom::inRandomOrder()->limit('1')->get()[0]->id,
        'created_at' => $faker->date($format = 'Y-m-d', $max = 'now') . ' ' . $faker->time($format = 'H:i:s', $max = 'now'),
    ];
});
