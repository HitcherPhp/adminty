<?php

namespace App\Models;

use App\Facades\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Facades\Message;
use Illuminate\Support\Facades\Log;


class CityFranchiseFactoryReceptionUserModel extends Model
{
    protected $table='city_franchise_factory_reception_user';
    public $timestamps = false;

    /*
    *   массив приходящий в метод create должен выглядеть следующим образом:
    *   $data = [
            'city_id' => NULL,
    *       'franchise_id' => NULL,
    *       'factory_id' => NULL,
    *       'reception_id' => NULL,
    *       'user_id' => NULL
    *   ]
    *  Вместо NULL Ваши значения
    */
    public static function create($data){
        DB::table('city_franchise_factory_reception_user')->insert($data);

    }

    public static function get_franchises($show, $operator, $user_id, $f_id, $search_attribute)
    {
        $franchises = CityFranchiseFactoryReceptionUserModel::join(
            'franchises',
            'franchises.id',
            '=',
            'city_franchise_factory_reception_user.franchise_id'
        )->select(
            'franchises.id as id', 'city_franchise_factory_reception_user.user_id'
        )
            ->where('franchises.deleted', '=', false)
            ->whereNull('city_franchise_factory_reception_user.factory_id')
            ->whereNull('city_franchise_factory_reception_user.reception_id');
        if ($operator) {
            $franchises->where('city_franchise_factory_reception_user.user_id', $operator, $user_id);
        }
        else {
            $franchises->whereNotNull('city_franchise_factory_reception_user.user_id');
        }
        if ($search_attribute) {
            $franchises->where('franchises.name', 'like', '%' . $search_attribute . '%');
        }
        if ($f_id) {
            $franchises->where('city_franchise_factory_reception_user.franchise_id', '<>', $f_id);
        }
        if ($show) {
            $franchises->addSelect('franchises.name as name');
        }

        return $franchises;
    }


    public static function check_franchise($id, $name) {

        $franchises = CityFranchiseFactoryReceptionUserModel::join('franchises', 'city_franchise_factory_reception_user.franchise_id', '=', 'franchises.id')
            ->where('city_franchise_factory_reception_user.franchise_id', '=', $id);
        if (Auth::user()->group_id == 2) {
            $franchises->where('city_franchise_factory_reception_user.user_id', '=', Auth::id());
        }
        $franchises->where('franchises.name', '=', $name)->first();
        if ($franchises) {
            return true;
        }
        return  false;
    }

    public static function get_city_data($franchise_id){
        $city_data = CityFranchiseFactoryReceptionUserModel::join('cities', 'city_franchise_factory_reception_user.city_id', '=', 'cities.id')
        ->join('timezones', 'cities.utc_id' , '=', 'timezones.id')
        ->where(function($query) use($franchise_id){
            $query->where('city_franchise_factory_reception_user.franchise_id', $franchise_id)
            ->where('city_franchise_factory_reception_user.factory_id', NULL)
            ->where('city_franchise_factory_reception_user.reception_id', NULL)
            ->where('city_franchise_factory_reception_user.user_id', NULL);
        })
        ->select('city_franchise_factory_reception_user.city_id', 'timezones.utc')
        ->get()->toArray();
        return [
            'city_id' => $city_data[0]['city_id'],
            'utc' => $city_data[0]['utc']
        ];
    }


    public static function get_admin_franchises($user_id){

        try {
            $franchise_ids = DB::table('city_franchise_factory_reception_user')
                ->select('franchise_id')
                ->where([
                    ['factory_id', NULL],
                    ['reception_id', NULL],
                    ['user_id', '=', $user_id]
                ])
                ->orderBy('franchise_id')
                ->get()
                ->toArray();
            if(empty($franchise_ids)){
                return Message::NOT_FOUND;
            }
            return $franchise_ids;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }


    }
























}
