<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\CityFranchiseFactoryReceptionUserModel;
use Illuminate\Support\Facades\DB;
use App\Models\FactoryModel;
use App\Models\FranchiseModel;
use App\Models\StaffModel;
use App\Models\ReceptionModel;
use App\Models\CityModel;

$factory->define(CityFranchiseFactoryReceptionUserModel::class, function (Faker $faker) {
    $fac = FactoryModel::latest('id')->first();
    $fra = FranchiseModel::latest('id')->first();
    $stf = StaffModel::latest('id')->first();
    $rec = ReceptionModel::latest('id')->first();
    $cit = CityModel::latest('id')->first();

    $check = mt_rand(0, 6);
    if($check == 0){
        #привязываем франшизы
        $city_id = mt_rand(1, $cit->id);
        $franchise_id = mt_rand(1, $fra->id);
        $factory_id = null;
        $reception_id = null;
        $user_id = null;
    }else if($check == 1){
        #привязываем фабрики
        $city_id = mt_rand(1, $cit->id);
        $franchise_id = mt_rand(1, $fra->id);
        $factory_id = mt_rand(1, $fac->id);
        $reception_id = null;
        $user_id = null;
    }else if($check == 2){
        #привязываем приемки
        $city_id = mt_rand(1, $cit->id);
        $franchise_id = mt_rand(1, $fra->id);
        $factory_id = null;
        $reception_id = mt_rand(1, $rec->id);
        $user_id = null;


    }else if($check == 3 or $check == 5){
        #привязываем сотрудников
        $city_id = mt_rand(1, $cit->id);
        $franchise_id = mt_rand(1, $fra->id);
        $factory_id = null;
        $reception_id = null;
        $user_id = mt_rand(1, $stf->id);

    }else if($check == 4 or $check == 6){
        #привязываем приемщиц
        $city_id = mt_rand(1, $cit->id);
        $franchise_id = mt_rand(1, $fra->id);
        $factory_id = null;
        $reception_id = mt_rand(1, $rec->id);
        $user_id = mt_rand(1, $stf->id);

    }

    return [
        'city_id' => $city_id,
        'franchise_id' => $franchise_id,
        'factory_id' => $factory_id,
        'reception_id' => $reception_id,
        'user_id' => $user_id
    ];
});
