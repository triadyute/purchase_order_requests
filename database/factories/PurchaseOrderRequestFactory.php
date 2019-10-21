<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\PurchaseOrderRequest;
use Faker\Generator as Faker;

$factory->define(PurchaseOrderRequest::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'manager_id' => 2,
        'approved_by_manager' => 'Approved',
        'approved_by_manager_on' => $faker->date('Y-m-d'),
        'senior_manager_id' => 3,
        'approved_by_senior_manager' => 'Approved',
        'approved_by_senior_manager_on' => $faker->date('Y-m-d'),
        'admin_id' => 4,
        'approved_by_admin' => $faker->randomElement(['Pending', 'Approved', 'Declined']),
        'approved_by_admin_on' => $faker->date('Y-m-d'),
        'category' => $faker->randomElement(['Training', 'New Equipment', 'Travel', 'Software']),
        'subcategory' => $faker->randomElement(['Hotel', 'Car', 'Books', 'Video courses', 'Laptop']),
        'request_details' => $faker->text,
        'amount' => $faker->randomElement([600, 1000, 10000]),
        'currency' => $faker->randomElement(['usd', 'gbp', 'eur']),
        'expected_on' => $faker->date('Y-m-d'),
    ];
});
