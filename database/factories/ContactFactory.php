<?php

$factory->define(App\Contact::class, function (Faker\Generator $faker) {
    return [
        'company_id' => factory('App\ContactCompany')->create(),
        'clinic_id'  => factory('App\Clinic')->create(),
        'user_id'    => factory('App\User')->create(),
        'first_name' => $faker->name,
        'last_name'  => $faker->name,
        'phone1'     => $faker->name,
        'phone2'     => $faker->name,
        'email'      => $faker->name,
        'skype'      => $faker->name,
        'notes'      => $faker->name,
    ];
});
