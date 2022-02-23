<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\DoctorPersonalInfo;
use Faker\Generator as Faker;

$factory->define(DoctorPersonalInfo::class, function (Faker $faker) {
    return [
        'doctor_unique_id' => $faker->randomDigitNotNull,
        'gender' => 'MALE',
        'date_of_birth' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'age' => $faker->randomDigitNotNull,
        'qualification' => $faker->word,
        'years_of_experience' => $faker->randomDigitNotNull,
    ];
});
