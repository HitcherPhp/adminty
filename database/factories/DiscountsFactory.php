<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Discounts\Models\DiscountModel;
use App\Models\CityModel;
use Faker\Generator as Faker;

$factory->define(DiscountModel::class, function (Faker $faker) {

    $starts = [
        0 => "DATE_SUB(NOW(), INTERVAL 15 DAY)",
        1 => "NOW()",
        2 => "DATE_SUB(NOW(), INTERVAL 30 DAY)"
    ];

    $ends = [
        0 => "DATE_ADD(NOW(), INTERVAL 30 DAY)",
        1 => "DATE_SUB(NOW(), INTERVAL 15 DAY)",
        2 => "DATE_SUB(NOW(), INTERVAL 30 DAY)"
    ];

    $percent = mt_rand(0,20);

    if ($percent === 0) {
        $price = mt_rand(100, 500);
    }
    else {
        $price = 0;
    }

    $cities = CityModel::all()->toArray();
    $cities_ids = array_column($cities, 'id');

    $city_id = $cities_ids[mt_rand(0, count($cities_ids)-1)];

    $promotion_id = $promotion_id = \App\Models\PromotionModel::select('id')->where('type','=', 'WEEK_PRODUCT')->first();;

    $products = \App\Models\ActualProductModel::where('city_id', $city_id)->where('published', true)->limit(mt_rand(2,10))->get()->toArray();

    $product_ids = '-1,'.implode(",", array_column($products, 'id'));

    $name = 'Вещь недели';

    $text = 'Скидки на популярные вещи этой недели.';

    $promotion = [
        'start' => DB::raw($starts[mt_rand(0,2)]),
        'end' => DB::raw($ends[mt_rand(0,2)]),
        'percent' => $percent,
        'price' => $price,
        'city_id' => $city_id,
        'promotion_id' => $promotion_id,
        'product_ids' => $product_ids,
        'name' => $name,
        'description' => $text
    ];

    return $promotion;
});
