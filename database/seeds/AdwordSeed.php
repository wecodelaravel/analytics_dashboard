<?php

use Illuminate\Database\Seeder;

class AdwordSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

        ];

        foreach ($items as $item) {
            \App\Adword::create($item);
        }
    }
}