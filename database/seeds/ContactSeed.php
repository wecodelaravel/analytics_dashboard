<?php

use Illuminate\Database\Seeder;

class ContactSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 1, 'company_id' => null, 'clinic_id' => null, 'user_id' => 2, 'first_name' => 'Phillip', 'last_name' => 'Madsen', 'phone1' => '385-282-6160', 'phone2' => '', 'email' => 'wecodelaravel@gmail.com', 'skype' => ''],


        ];

        foreach ($items as $item) {
            \App\Contact::create($item);
        }
    }
}