<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryModel extends Model
{
    protected $table = 'categories';

    public $timestamps = false;


    public static function main_categories($attr) {
        try {

            $model = DB::table('city_category_product as ccp')
                ->select('pc.id as id', 'pc.name as name')
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->leftJoin('categories as pc', DB::raw("find_in_set(pc.id, c.parent_ids) <> 0 or pc.id"), '=', 'ccp.category_id')
                ->whereRaw("ccp.city_id = ".$attr['city_id']." and ccp.published = true and pc.parent_id is Null")
                ->distinct()->get()->toArray();

            if (empty($model)) {
                return Message::NOT_FOUND;
            }

            return $model;

        }
        catch (Exception $e) {

            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }


    public static function categories($attr)
    {
        try {

            return DB::table('city_category_product as ccp')
                ->select('pc.id as id', 'pc.name as name', 'pc.parent_id as parent_id')
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->leftJoin('categories as pc', DB::raw("find_in_set(pc.id, c.parent_ids) <> 0 or pc.id"), '=', 'ccp.category_id')
                ->whereRaw("ccp.city_id = " . $attr['city_id'] . " and ccp.published = true")
                ->distinct()->get()->toArray();

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);
            return Error::NOT_FOUND;
        }

    }


    







}
