<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Specializations;
use Faker\Generator as Faker;

$factory->define(Specializations::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
