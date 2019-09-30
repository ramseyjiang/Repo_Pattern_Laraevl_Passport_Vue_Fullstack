<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Rspafs\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
    ];
});
