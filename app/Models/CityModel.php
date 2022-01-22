<?php

namespace App\Models;

use App\Facades\Message;
use App\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Exception;

class CityModel extends Model
{
    protected $table = 'cities';
    public $timestamps = false;


    public static function city_by_alias($alias) {

        try {

            $query = DB::table('cities as c')
                ->select('c.id as city_id')
                ->where('c.alias', '=', $alias)
                ->first();

            if (empty($query)) {
                return Message::NOT_FOUND;
            }

            return $query;

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }


    public static function cities() {

        try {

            $cities = DB::table('cities as c')
                ->select(
                    'c.id as city_id',
                    'c.name as city_name',
                    'c.country_id as country_id',
                    'f.phone as factory_phone'
                )
                ->join('factories as f', 'f.id', '=', 'c.factory_id')
                ->where('f.deleted', '=', false)
                ->get()->toArray();

            if(empty($cities)){
                return Message::NOT_FOUND;
            }
            return $cities;

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }
    }


    
}
