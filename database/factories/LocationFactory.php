<?php

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    return [
        'parent_website_id'   => factory('App\Website')->create(),
        'clinic_website_link' => $faker->name,
        'clinic_id'           => factory('App\Clinic')->create(),
        'clinic_location_id'  => $faker->randomNumber(2),
        'nickname'            => $faker->name,
        'contact_person_id'   => factory('App\Contact')->create(),
        'address'             => $faker->name,
        'address_2'           => $faker->name,
        'city'                => $faker->name,
        'state'               => $faker->name,
        'location_email'      => $faker->safeEmail,
        'phone'               => $faker->name,
        'phone2'              => $faker->name,
        'google_map_link'     => $faker->name,
        'created_by_id'       => factory('App\User')->create(),
    ];
});
