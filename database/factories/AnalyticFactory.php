<?php

$factory->define(App\Analytic::class, function (Faker\Generator $faker) {
    return [
        'view_name'  => $faker->name,
        'view_id'    => $faker->name,
        'website_id' => factory('App\Website')->create(),
    ];
});
