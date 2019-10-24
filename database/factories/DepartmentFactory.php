<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement(['Cloud Services', 'Software Development', 'Accounts']),
    ];
});
