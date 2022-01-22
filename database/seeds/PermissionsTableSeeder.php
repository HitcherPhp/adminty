<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'franchises|view',
                'description' => ' ',
            ],
            [
                'id' => 2,
                'name' => 'factories|view',
                'description' => ' ',
            ],
            [
                'id' => 3,
                'name' => 'receptions|view',
                'description' => ' ',
            ],
            [
                'id' => 4,
                'name' => 'staff|view',
                'description' => ' ',
            ],
            [
                'id' => 5,
                'name' => 'customers|view',
                'description' => ' ',
            ],
            [
                'id' => 6,
                'name' => 'orders|view',
                'description' => ' ',
            ],
            [
                'id' => 7,
                'name' => 'promo_codes|view',
                'description' => ' ',
            ],
            [
                'id' => 8,
                'name' => 'select_franchises|view',
                'description' => ' ',
            ],
            [
                'id' => 9,
                'name' => 'all_staff_table|view',
                'description' => ' ',
            ],
            [
                'id' => 10,
                'name' => 'all_factories_table|view',
                'description' => ' ',
            ],


        ];
        DB::table('permissions')->insert($permissions);
    }
}
