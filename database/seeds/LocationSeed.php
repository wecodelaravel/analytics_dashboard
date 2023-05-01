<?php

use Illuminate\Database\Seeder;

class LocationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'parent_website_id' => null, 'clinic_website_link' => null, 'clinic_id' => null, 'clinic_location_id' => null, 'nickname' => 'Affordable Programmer', 'contact_person_id' => null, 'address' => 'blah blah blah', 'address_2' => '', 'city' => 'midvale', 'state' => 'ut', 'location_email' => null, 'phone' => '385-555-6160', 'phone2' => '', 'storefront' => null, 'google_map_link' => 'blah blah blah utah 84047', 'created_by_id' => null],


        ];

        foreach ($items as $item) {
            \App\Location::create($item);
        }
    }
}