<?php

use App\Models\User;
use Faker\Generator as Faker;
use Faker\Provider\pt_BR\Company;
use Faker\Provider\pt_BR\Person;

$factory->define(User::class, function (Faker $faker) {
    $faker->addProvider(new Person($faker));
    $faker->addProvider(new Company($faker));

    $type = $faker->randomElement(['company', 'person']);

    if ($type === 'person') {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'cpf_cnpj' => $faker->unique()->cpf(false),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'type' => $type
        ];
    } else {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'cpf_cnpj' => $faker->unique()->cnpj(false),
            'type' => $type
        ];
    }
});
