<?php

use Illuminate\Database\Seeder;

class WebsiteSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'company_id' => 1, 'clinic_id' => 1, 'website' => 'url.com'],


        ];

        foreach ($items as $item) {
            \App\Website::create($item);
        }
    }
}