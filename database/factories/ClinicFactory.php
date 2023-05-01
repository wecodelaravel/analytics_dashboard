<?php

$factory->define(App\Clinic::class, function (Faker\Generator $faker) {
    return [
        'nickname'   => $faker->name,
        'company_id' => factory('App\ContactCompany')->create(),
        'notes'      => $faker->name,
    ];
});
