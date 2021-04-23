<?php

use App\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'value' => $faker->randomFloat(2, 0, 500),
    ];
});
