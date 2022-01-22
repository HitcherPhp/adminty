<?php

use Illuminate\Database\Seeder;
use App\Discounts\Models\DiscountModel;
use App\Models\CityModel;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = CityModel::all()->toArray();
        $city_ids = array_column($cities, 'id');

        $promotion_id = \App\Models\PromotionModel::select('id')->where('type','=', 'FREE_SHIPPING')->first();

        $free_shipping_discounts = [];

        foreach ($city_ids as $city_id) {

            $products = \App\Models\ActualProductModel::where('city_id', $city_id)->where('published', true)->get()->toArray();

            $product_ids = '-1,'.implode(",", array_column($products, 'id'));

            $free_shipping_discounts[] = [
                'start' => DB::raw("NOW()"),
                'end' => DB::raw("NOW()"),
                'percent' => 0,
                'price' => 0,
                'city_id' => $city_id,
                'promotion_id' => $promotion_id->id,
                'product_ids' => $product_ids,
                'name' => 'Бесплатная доставка',
                'description' => 'Бесплатная доставка по определенным условиям.'
            ];
        }

        DB::table('discounts')->insert($free_shipping_discounts);

        factory(DiscountModel::class, 60)->create();

        $cities = CityModel::all()->toArray();
        $cities_ids = array_column($cities, 'id');

    }
}
