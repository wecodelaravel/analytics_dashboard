<?php

use Illuminate\Database\Seeder;

class RoleSeedPivot extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [

            1 => [
                'permission' => [1, 6, 7, 8, 9, 10, 16, 17, 18, 19, 20, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 84, 85, 86, 87, 89, 94, 95, 96, 97, 99, 100, 101, 102, 11, 12, 13, 14, 15, 104, 105, 106, 107, 108, 114, 115, 116, 117, 118],
            ],
            3 => [
                'permission' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 16, 17, 18, 19, 20, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 89, 99, 100, 101, 102, 103, 84, 85, 86, 87, 88, 94, 95, 96, 97, 98, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118],
            ],


        ];

        foreach ($items as $id => $item) {
            $role = \App\Role::find($id);

            foreach ($item as $key => $ids) {
                $role->{$key}()->sync($ids);
            }
        }
    }
}