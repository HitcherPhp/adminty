<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaffModel;
use App\Models\CityModel;
use App\Models\CustomerModel;
use App\Models\PromoCodeModel;
use App\Models\TypeOfOwnershipModel;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(PromoCodeModel::class, function (Faker $faker) {
    $cm = CityModel::latest('id')->first();
    $cum = CustomerModel::latest('id')->first();
    $tom = TypeOfOwnershipModel::latest('id')->first();

    $check = mt_rand(0,1);

    if($check){
        $d = mt_rand(200, 1000);
        $d_t = 1;
        $discount_percent = mt_rand(15, 70);
        $discount_price = 0.00;
        $customer_id = mt_rand(1, $cum->id);
        $type_of_ownership_id = '-1';
    }else{
        $d = mt_rand(5, 70);
        $d_t = 2;
        $discount_percent = 0.00;
        $discount_price = mt_rand(130, 300);
        $customer_id = '-1';
        $type_of_ownership_id = mt_rand(1, $tom->id);
    }

    return [
        'name' => $faker->word,
        'city_id' => mt_rand(1, $cm->id),
        'customer_ids' => $customer_id,
        'discount_percent' => $discount_percent,
        'discount_price' => $discount_price,
        'start' => '2021-02-17 14:13:11',
        'end' => '2021-04-03 14:13:11',
        'type_of_ownership_ids' => $type_of_ownership_id,
        'category_ids' => '-1',
        'product_ids' => '-1',
        'deleted' => mt_rand(0,1),
    ];

});
