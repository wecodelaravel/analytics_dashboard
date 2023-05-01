<?php

$factory->define(App\Zipcode::class, function (Faker\Generator $faker) {
    return [
        'zipcode'     => $faker->name,
        'clinic_id'   => factory('App\Clinic')->create(),
        'location_id' => factory('App\Location')->create(),
    ];
});
