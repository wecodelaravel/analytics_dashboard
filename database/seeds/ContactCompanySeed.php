<?php

use Illuminate\Database\Seeder;

class ContactCompanySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'name' => 'BLAH Sciences', 'logo' => null],
            ['id' => 2, 'name' => 'BLAH Hawaii', 'logo' => null],
            ['id' => 3, 'name' => 'BLAH Pasadena', 'logo' => null],
            ['id' => 4, 'name' => 'BLAH San Antonio', 'logo' => null],

        ];

        foreach ($items as $item) {
            \App\ContactCompany::create($item);
        }
    }
}