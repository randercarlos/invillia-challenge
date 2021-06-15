<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Phone;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Phone::class, function (Faker $faker) {
    return [
        'phone' => Arr::random(['(21) 99645-0305', '(16) 2466-8975', '(11) 96583-0603'])
    ];
});
