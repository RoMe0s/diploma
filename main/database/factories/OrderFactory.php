<?php

use App\Models\Order\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'description' => $faker->text,
        'estimate' => $faker->numberBetween(1, 100),
        'price' => $faker->numberBetween(50, 100),
        'name' => $faker->unique()->name
    ];
});