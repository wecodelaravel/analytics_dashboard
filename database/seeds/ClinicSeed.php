<?php

use Illuminate\Database\Seeder;

class ClinicSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'nickname' => 'BLAH of America', 'logo' => null, 'company_id' => 1, 'notes' => null],
            ['id' => 2, 'nickname' => 'BLAH Hawaii', 'logo' => null, 'company_id' => 2, 'notes' => null],
            ['id' => 4, 'nickname' => 'BLAH Pasadena', 'logo' => null, 'company_id' => 3, 'notes' => null],

        ];

        foreach ($items as $item) {
            \App\Clinic::create($item);
        }
    }
}