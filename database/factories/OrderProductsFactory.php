<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderProductsModel;
use App\Models\ActualProductModel;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

$factory->define(OrderProductsModel::class, function (Faker $faker) {
    $apm = ActualProductModel::latest('id')->first();
    $om = OrderModel::latest('id')->first();

    $order_id = mt_rand(1, $om->id);


    $data = DB::table('orders as o')
        ->join('receptions as r', 'o.reception_id', '=', 'r.id')
        ->join('addresses as adr', 'r.address_id', '=', 'adr.id')
        ->select(
            'o.id as order_id',
            'adr.city_id',
            'r.household'
            )
        ->where('o.id', $order_id)
        ->get()
        ->toArray();

    $city_id = $data[0]->city_id;



    if($data[0]->household == 0){
        $s = DB::table('city_category_product as ccp')
            ->join('products as p', 'ccp.product_id', '=', 'p.id')
            ->select(
                'ccp.id as id',
                )
            ->where([
                ['ccp.city_id', $city_id],
                ['ccp.service_type_id', 1]
            ])
            ->get()
            ->toArray();
    }else{
        $s = DB::table('city_category_product as ccp')
            ->join('products as p', 'ccp.product_id', '=', 'p.id')
            ->select(
                'ccp.id as id',
                )
            ->where([
                ['ccp.city_id', $city_id]
            ])
            ->get()
            ->toArray();
    }


    $ccp_ids = array_column($s, 'id');

    $ccp_ids_key = array_rand($ccp_ids, 1);

    $product_id = $ccp_ids[$ccp_ids_key];


    $check = mt_rand(0,1);
    $check_2 = mt_rand(0,3);
    $price = mt_rand(450, 890);
    $count = mt_rand(1, 5);

    if($check){
        $discount_percent = mt_rand(15, 70);
        $discount_price = 0.00;

        $estimate_price = ($price * (100 - $discount_percent) / 100) * $count;
    }else{
        $discount_percent = 0.00;
        $discount_price = mt_rand(130, 300);

        $estimate_price = ($price - $discount_price) * $count;
    }

    if($check_2 == 3){
        $discount_percent = null;
        $discount_price = null;
    }


    return [
        'order_id' => $order_id,
        'product_id' => $product_id,
        'count' => $count,
        'price' => $price,
        'discount_percent' => $discount_percent,
        'discount_price' => $discount_price,
        'estimate_price' => $estimate_price
    ];
});
