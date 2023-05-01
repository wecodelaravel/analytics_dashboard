<?php

$factory->define(App\ApiTest::class, function (Faker\Generator $faker) {
    return [
        'submitted'            => $faker->name,
        'name'                 => $faker->name,
        'email'                => $faker->name,
        'subject'              => $faker->name,
        'message'              => $faker->name,
        'submitted_user_city'  => $faker->name,
        'submitted_user_state' => $faker->name,
        'searched_for'         => $faker->name,
        'country'              => $faker->name,
        'latitude'             => $faker->name,
        'longitude'            => $faker->name,
    ];
});
