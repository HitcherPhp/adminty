<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\FactoryModel;
use Illuminate\Support\Facades\DB;

$factory->define(FactoryModel::class, function (Faker $faker) {
    $ad = DB::table('addresses')->latest('id')->first();

    $factories = [
        'address_id' => mt_rand(1, $ad->id),
        'phone' => mt_rand(89005400000, 89999999999),
        'creator_id' => mt_rand(1,3),
        'deleted' => mt_rand(0,1),
    ];

    return $factories;
});
