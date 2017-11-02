<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\User::class, function (Faker $faker) {
    return [
//        'balance' => $faker->randomNumber()
        'balance' => mt_rand(0, 3000),
    ];
});
