<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\ReceptionModel;
use Illuminate\Support\Facades\DB;

$factory->define(ReceptionModel::class, function (Faker $faker) {
    $ad = DB::table('addresses')->latest('id')->first();

    $receptions = [
        'address_id' => mt_rand(1, $ad->id),
        'phone' => mt_rand(89005400000, 89999999999),
        'discount_percent' => mt_rand(5,60),
        'length' => mt_rand(40,120),
        'width' => mt_rand(22,84),
        'height' => mt_rand(75,105),
        'weight' => mt_rand(16,70),
        'creator_id' => mt_rand(1,3),
        'household' => mt_rand(0,1),
        'deleted' => mt_rand(0,1),
    ];

    return $receptions;
});
