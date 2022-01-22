<?php

use Illuminate\Database\Seeder;

class ServiceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_type')->insert([
            [
                'name' => 'Химчистка',
                'main_category_id' => 1
            ],
            [
                'name' => 'Крашение',
                'main_category_id' => 2
            ],
            [
                'name' => 'Хранение',
                'main_category_id' => 3
            ],
            [
                'name' => 'Ремонт',
                'main_category_id' => 4
            ],
        ]);
    }
}
