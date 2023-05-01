<?php

$factory->define(App\TrackingNumber::class, function (Faker\Generator $faker) {
    return [
        'metrics_id'           => $faker->name,
        'number'               => $faker->name,
        'location_id'          => factory('App\Location')->create(),
        'company_id'           => factory('App\ContactCompany')->create(),
        'callmetric_filter_id' => $faker->name,
    ];
});
