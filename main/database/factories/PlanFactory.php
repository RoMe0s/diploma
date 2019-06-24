<?php

use App\Models\Plan\Block;
use App\Models\Plan\Key;
use App\Models\Plan\Plan;
use App\Models\Plan\SettingBlock;
use Faker\Generator as Faker;

$factory->define(Plan::class, function (Faker $faker) {
    return [
        'size_from' => $faker->numberBetween(500, 1000),
        'size_to' => $faker->numberBetween(1000, 2000)
    ];
});

$factory->define(Block::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'heading' => \App\Constants\Plan\Heading::H2,
        'size_from' => $faker->numberBetween(100, 500),
        'size_to' => $faker->numberBetween(500, 1000)
    ];
});

$factory->define(Key::class, function (Faker $faker) {
    return [
        'value' => $faker->name,
        'type' => \App\Constants\Plan\Key::STRICT,
        'count' => $faker->numberBetween(1, 5)
    ];
});

$factory->define(SettingBlock::class, function (Faker $faker) {
    $types = \App\Constants\Plan\SettingBlock::ALL;
    return [
        'type' => $types[rand(1, count($types)) - 1],
        'min' => $faker->numberBetween(1, 3),
        'max' => $faker->numberBetween(3, 5)
    ];
});