<?php

$factory->define(App\Booking::class, function (Faker\Generator $faker) {
    return [
        'customername'         => $faker->name,
        'phone'                => $faker->name,
        'family_number'        => $faker->name,
        'email'                => $faker->name,
        'how_long'             => $faker->name,
        'requested_date'       => $faker->name,
        'requested_time'       => $faker->name,
        'requested_clinic'     => $faker->name,
        'clinic_id'            => $faker->name,
        'clinic_email'         => $faker->name,
        'clinic_address'       => $faker->name,
        'clinic_phone'         => $faker->name,
        'clinic_text_numbers'  => $faker->name,
        'client_firstname'     => $faker->name,
        'submitted_user_city'  => $faker->name,
        'submitted_user_state' => $faker->name,
        'searched_for'         => $faker->name,
        'latitude'             => $faker->name,
        'longitude'            => $faker->name,
        'country'              => $faker->name,
        'submitted'            => $faker->name,
    ];
});
