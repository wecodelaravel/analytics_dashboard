<?php

use Illuminate\Database\Seeder;

class AnalyticSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'view_name' => 'Master View', 'view_id' => '117039068', 'website_id' => 1],

        ];

        foreach ($items as $item) {
            \App\Analytic::create($item);
        }
    }
}
