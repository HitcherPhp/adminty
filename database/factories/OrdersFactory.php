<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderModel;
use Faker\Generator as Faker;
use App\Models\PromoCodeModel;
use App\Models\CustomerModel;
use App\Models\ReceptionModel;
use App\Models\AddressesModel;
use Carbon\Carbon;

$factory->define(OrderModel::class, function (Faker $faker) {
    $cm = CustomerModel::latest('id')->first();
    $rm = ReceptionModel::latest('id')->first();
    $pc = PromoCodeModel::latest('id')->first();
    $ad = AddressesModel::latest('id')->first();

    $base_price = mt_rand(5000, 12000);
    $basket_price = $base_price - mt_rand(1000, 3500);
    $bonuse_price = mt_rand(0, 500);
    $delivery_price = mt_rand(120, 195);
    $estimate_cost = $basket_price - $bonuse_price + $delivery_price;

    $check = mt_rand(0,1);
    if($check){
        $adr_tk = mt_rand(1, $ad->id);
        $adr_rt = mt_rand(1, $ad->id);
        $prm_code = mt_rand(1, $pc->id);
    }else{
        $adr_tk = null;
        $adr_rt = null;
        $prm_code = null;
    }

    $orders = [
        'number' => (string)(mt_rand(1000, 9999)),
        'customer_id' => mt_rand(1, $cm->id),
        'reception_id' => mt_rand(1, $rm->id),
        'promo_code_id' => $prm_code,
        'base_price' => $base_price,
        'basket_price' => $basket_price,
        'bonus_price' => $bonuse_price,
        'total_weight' => mt_rand(2, 6),
        'discount_sum' => mt_rand(100, 300),
        'delivery_price' => $delivery_price,
        'estimate_price' => $estimate_cost,
        'address_take_id' => $adr_tk,
        'address_return_id' => $adr_rt,
        'payment_method_id' => mt_rand(1,2),
        'customer_comment' =>$faker->text,
        'deleted' => mt_rand(0,1),
    ];
    return $orders;
});
