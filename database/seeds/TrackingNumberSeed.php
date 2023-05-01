<?php

use Illuminate\Database\Seeder;

class TrackingNumberSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'metrics_id' => '101030L', 'number' => '+12105559827 ', 'location_id' => null, 'company_id' => 4],
            ['id' => 2, 'metrics_id' => '101030L', 'number' => '+12105559947', 'location_id' => null, 'company_id' => 4],
            ['id' => 3, 'metrics_id' => '101030L', 'number' => '+12105559977', 'location_id' => null, 'company_id' => 4],


        ];

        foreach ($items as $item) {
            \App\TrackingNumber::create($item);
        }
    }
}