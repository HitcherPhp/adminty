<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\StatusesGroupsModel;

$factory->define(StatusesGroupsModel::class, function (Faker $faker) {
    static $or = 1;
    return [
        'status_id' => mt_rand(1, 13),
        'order_id' => $or++,
    ];
});
