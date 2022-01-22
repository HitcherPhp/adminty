<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BonusPointsModel;
use App\Models\CustomerModel;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(BonusPointsModel::class, function (Faker $faker) {

    $bonus_points = [
        'bonus_type_id' => mt_rand(1,2),
        'points' => mt_rand(50,100)
    ];

    $clients = CustomerModel::select('id')->get()->toArray();

    $user_id = $clients[mt_rand(0, (count($clients))-1)]['id'];

    $parent = BonusPointsModel::select('id')->where('customer_id', '=', $user_id)->where('parent_id', '=', NULL)->get()->toArray();

    $bonus_points['parent_id'] = $parent[mt_rand(0, (count($parent))-1)]['id'];

    $bonus_points['customer_id'] = $user_id;

    switch (mt_rand(1,3)) {
        case 1:
            $bonus_points['event'] = 'added';
            break;
        case 2:
            $bonus_points['event'] = 'subtracted';
            break;
        case 3:
            $bonus_points['event'] = 'burned';
            break;
    }
    $bonus_points['start'] = DB::raw('NOW()');
    return $bonus_points;
});
