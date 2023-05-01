<?php

$factory->define(App\Website::class, function (Faker\Generator $faker) {
    return [
        'company_id' => factory('App\ContactCompany')->create(),
        'clinic_id'  => factory('App\Clinic')->create(),
        'website'    => $faker->name,
    ];
});
