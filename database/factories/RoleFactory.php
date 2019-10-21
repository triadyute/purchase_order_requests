<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['User', 'Manager', 'Senior Manager', 'Admin', 'SuperUser']),
        'description' => $faker->sentence
    ];
});

$factory->state(Role::class, 'SUPERUSER', ['name' => 'SuperUser']);