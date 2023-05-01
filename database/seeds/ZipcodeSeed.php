<?php

use Illuminate\Database\Seeder;

class ZipcodeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'zipcode' => '96753', 'clinic_id' => 2, 'location_id' => 3],


        ];

        foreach ($items as $item) {
            \App\Zipcode::create($item);
        }
    }
}