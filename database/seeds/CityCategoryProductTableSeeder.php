<?php

use Illuminate\Database\Seeder;
use App\Models\ProductModel;
use App\Categories\Models\CategoryModel;
use Illuminate\Support\Facades\DB;

class CityCategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Models\ActualProductModel::class, 1056)->create();




        $cities = \App\Models\CityModel::get()->toArray();
        $catalog = \App\Facades\Catalog::CATEGORIES_PRODUCTS;


        $actualProducts = [];

        foreach ($cities as $city) {

            foreach ($catalog as $category => $products) {
                $last_category = CategoryModel::select('c.id as id', 'st.id as service_id')->from('categories as c')
                    ->where('c.id', $category)
                    ->lastCategories()->ServiceType()->get()->toArray()[0];
                foreach ($products as $product) {

                    for ($i = 0; $i <= 1; $i++) {

                        if(!$i) {
                            $price = mt_rand(600, 2000);
                        }
                        else {
                            if (isset($price)) {
                                $price += mt_rand(150, 300);
                            }
                        }

                        $actualProducts[] = [
                            'city_id' => $city['id'],
                            'category_id' => $last_category['id'],
                            'product_id' => $product,
                            'price' => $price,
                            'service_type_id' => $last_category['service_id'],
                            'is_vip' => $i,
                            'published' => mt_rand(0,1)
                        ];

                    }

                }

            }

        }

        foreach (array_chunk($actualProducts, 200) as $ap) {

            DB::table('city_category_product')->insert($ap);

        }
    }
}
