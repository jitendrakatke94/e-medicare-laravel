<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Model\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'pincode' => $faker->postcode,
        'street_name' => $faker->streetName,
        'city_village' => $faker->streetAddress,
        'district' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'contact_number' => $faker->phoneNumber,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'address_type' => 'CLINIC',
    ];
});
