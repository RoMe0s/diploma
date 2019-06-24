<?php

use App\Models\Text;
use App\Models\Task\Task;
use App\Models\Order\Commit;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
   return [];
});

$factory->define(Text::class, function (Faker $faker) {
   return [];
});

$factory->define(Commit::class, function (Faker $faker) {
   return [];
});