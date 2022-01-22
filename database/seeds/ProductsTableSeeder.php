<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $names = \App\Facades\Catalog::PRODUCTS;
        $products = [];

        foreach ($names as $name) {
            $products[] = [
                'id' => $name['id'],
                'name' => $name['name'],
                'period' => '3-4 дня',
                'image_id' => 1,
                'description' => 'text'
            ];
        }

        DB::table('products')->insert($products);

    }
}
