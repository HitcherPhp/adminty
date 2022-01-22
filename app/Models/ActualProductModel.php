<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Exception;

class ActualProductModel extends Model
{

    protected $table = 'city_category_product';
    public $timestamps = false;


    public static function popular_products($attr)
    {
        try {

            return DB::table('city_category_product as ccp')
                ->select(
                    'ccp.id as id',
                    'p.name as name',
                    DB::raw("ROUND(ccp.price, 0) as old_price"),
                    DB::raw("ROUND(ccp.price * (1 - d.percent / 100), 0) as new_price"),
                    'd.percent as percent',
                    DB::raw("CONCAT(i.path, i.name) as image_url")
                )
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->join('products as p', 'ccp.product_id', '=', 'p.id')
                ->leftJoin('discounts as d', 'ccp.discount_id', '=', 'd.id')
                ->leftJoin('images as i', 'p.image_id', '=', 'i.id')
                ->whereRaw("ccp.city_id = ".$attr['city_id']." and ccp.published = true and (FIND_IN_SET(".$attr['category_id'].", c.parent_ids) <> 0 or ccp.category_id = ".$attr['category_id'].")")
                ->limit($attr['limit'])->get()->toArray();

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::NOT_FOUND;
        }

    }


    public static function products($attr) {

        try {

            if (!isset($attr['limit'])) {
                $attr['limit'] = 1000;
            }

            return DB::table('city_category_product as ccp')
                ->select(
                    'ccp.id as id',
                    'p.name as name',
                    DB::raw("ROUND(ccp.price, 0) as old_price"),
                    DB::raw("ROUND(ccp.price * (1 - d.percent / 100), 0) as new_price"),
                    'd.percent as percent',
                    DB::raw("CONCAT(i.path, i.name) as image_url")
                )
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->join('products as p', 'ccp.product_id', '=', 'p.id')
                ->leftJoin('discounts as d', 'ccp.discount_id', '=', 'd.id')
                ->leftJoin('images as i', 'p.image_id', '=', 'i.id')
                ->whereRaw("ccp.city_id = ".$attr['city_id']." and ccp.published = true and (FIND_IN_SET(".$attr['category_id'].", c.parent_ids) <> 0 or ccp.category_id = ".$attr['category_id'].")")
                ->limit($attr['limit'])->get()->toArray();

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::NOT_FOUND;
        }

    }



    public static function product_card($attr) {

        $product_item = self::product_item($attr);

        if (Message::NOT_FOUND === $product_item or $product_item === null) {
            return Message::NOT_FOUND;
        }

        $product_item->events = self::product_promotions($attr);

        if (Message::NOT_FOUND === $product_item->events) {
            $product_item->events = [];
        }

        return $product_item;
    }

    private static function product_item(&$attr) {

        try {

            return DB::table('city_category_product as ccp')
                ->select(
                    'ccp.id as id',
                    'p.name as name',
                    DB::raw("ROUND(ccp.price, 0) as old_price"),
                    DB::raw("ROUND(ccp.price * (1 - d.percent / 100), 0) as new_price"),
                    DB::raw("ROUND(ccp.price, 0) - ROUND(ccp.price * (1 - d.percent / 100), 0) as profit"),
                    'd.percent as percent',
                    DB::raw("CONCAT(i.path, i.name) as image_url"),
                    DB::raw("SUBSTRING_INDEX(p.description,'\n', 1) as description"),
                    DB::raw("SUBSTRING_INDEX(p.description,'\n', -1) as full_description")
                )
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->join('products as p', 'ccp.product_id', '=', 'p.id')
                ->leftJoin('discounts as d', 'ccp.discount_id', '=', 'd.id')
                ->leftJoin('images as i', 'p.image_id', '=', 'i.id')
                ->whereRaw("ccp.id = ".$attr['id'])
                ->first();

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::NOT_FOUND;
        }
    }


    private static function product_promotions(&$attr) {

        try {

            return DB::table('city_category_product as ccp')
                ->select(
                    'd.id as id',
                    'd.name as name'
                )
                ->join('discounts as d', DB::raw("FIND_IN_SET(d.id, ccp.promotion_ids)"), '<>', DB::raw("0"))
                ->join('promotions as p', 'p.id', '=', 'd.promotion_id')
                ->whereRaw("ccp.id = ".$attr['id']." and d.deleted = false and p.deleted = false")
                ->get()->toArray();

        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }

    public static function product_comments($attr) {

        try {

            if (!isset($attr['limit'])) {
                $attr['limit'] = 10;
            }

            $query = DB::table('comments as cmnt')
                ->select(
                    'cmnt.id as id',
                    'cmnt.comment as comment',
                    DB::raw("convert_tz(cmnt.created_at, '+00:00', (select tz.utc from city_category_product as ccp join cities as cts on cts.id = ccp.city_id join timezones as tz on tz.id = cts.timezone_id WHERE ccp.id = cmnt.product_id)) as created_at"),
                    'cstm.name as customer_name',
                    'rtng.mark as mark'
                )
                ->join('ratings as rtng', 'cmnt.id', '=', 'rtng.comment_id')
                ->join('customers as cstm', 'cmnt.customer_id', '=', 'cstm.id')
                ->where('cmnt.product_id','=', $attr['id'])
                ->orderByDesc('cmnt.created_at');

            $paginator = $query->paginate($attr['limit']);

            $response = new \stdClass();

            $response->{'items'} = $paginator->items();
            $response->{'last_page'} = $paginator->lastPage();

            return $response;


        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }


    public static function add_product_comment($attr) {

        try {

            $comment_id = DB::table('comments')
                ->insertGetId(
                    [
                        'comment' => $attr['comment'],
                        'product_id' => $attr['product_id'],
                        'customer_id' => $attr['customer_id'],
                        'created_at' => DB::raw("NOW()")
                    ]
                );

            DB::table('ratings')
                ->insert(
                    [
                        'comment_id' => $comment_id,
                        'mark' => $attr['mark']
                    ]
                );

            return $comment_id;


        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }


    public static function edit_product_comment($attr) {

        try {

            DB::table('comments')
                ->where('id', $attr['comment_id'])
                ->update(
                    [
                        'comment' => $attr['comment'],
                        'created_at' => DB::raw("NOW()")
                    ]
                );

            if (isset($attr['mark'])) {

                DB::table('ratings')
                    ->where('comment_id', $attr['comment_id'])
                    ->update(
                        [
                            'mark' => $attr['mark']
                        ]
                    );

            }

            return $attr['comment_id'];


        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }

    }


    public static function product_comment($attr) {
        try {

            return DB::table('comments as cmnt')
                ->select(
                    'cmnt.id as id',
                    'cmnt.comment as comment',
                    DB::raw("convert_tz(cmnt.created_at, '+00:00', (select tz.utc from city_category_product as ccp join cities as cts on cts.id = ccp.city_id join timezones as tz on tz.id = cts.timezone_id WHERE ccp.id = cmnt.product_id)) as created_at"),
                    'cstm.name as customer_name',
                    'rtng.mark as mark'
                )
                ->join('ratings as rtng', 'cmnt.id', '=', 'rtng.comment_id')
                ->join('customers as cstm', 'cmnt.customer_id', '=', 'cstm.id')
                ->where('cmnt.id','=', $attr['comment_id'])
                ->first();



        } catch (Exception $e) {
            Log::channel('db_fail')->info($e);

            return Message::SERVER_ERROR;
        }
    }

    public static function get_added_product_data($data){

        try {
            $product_data = DB::table('city_category_product as ccp')
                ->join('categories as c', 'ccp.category_id', '=', 'c.id')
                ->leftJoin('discounts as d', 'ccp.discount_id', '=', 'd.id')
                ->select(
                    'c.id as categoty_id',
                    'c.name as categoty_name',
                    'ccp.price',
                    'd.percent as discount_percent',
                    'd.price as discount_price'
                    )
                ->where('ccp.id', $data['id'])
                ->get()
                ->toArray();

            if(empty($product_data)){
                return Message::NOT_FOUND;
            }

            $estimate_price = BasketMathModel::math_product_estimate_price($product_data[0], $data['count']);
            $product_data[0]->estimate_price = $estimate_price[0]['estimate_price'];
            $product_data = OrderProductsModel::convert_discount_data($product_data);

            return $product_data;


        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

    }








}
