<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShipOrder;
use App\Models\Person;
use Faker\Generator as Faker;

$factory->define(ShipOrder::class, function (Faker $faker) {
    return [
        'person_id' => factory(Person::class),
        'destinatary_name' => $faker->name,
        'destinatary_address' => $faker->address,
        'destinatary_city' => $faker->city,
        'destinatary_country' => $faker->country
    ];
});
