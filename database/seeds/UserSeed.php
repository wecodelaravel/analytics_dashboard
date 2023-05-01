<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            ['id' => 2, 'name' => 'admin', 'email' => 'admin@url.com', 'password' => '$2y$10$eZS/3ia1eXiwC1vonyqRg.OdgPKwjlbwmS5dnPc3l8AHmG2UFfI5a', 'remember_token' => null],


        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}