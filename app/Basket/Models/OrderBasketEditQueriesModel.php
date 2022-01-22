<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Facades\Message;

class OrderBasketEditQueriesModel extends Model
{
    /*
    * данная модель служит для запросов при изменении данных в корзине
    */


    public static function get_promocode_data($id){
        try {
            $promocode = DB::table('orders as o')
                ->leftJoin('promo_codes as p_c', 'o.promo_code_id', '=', 'p_c.id')
                ->select(
                    'p_c.id',
                    'p_c.discount_percent',
                    'p_c.discount_price',
                    'p_c.customer_ids',
                    'p_c.type_of_ownership_ids',
                    'p_c.category_ids',
                    'p_c.product_ids',
                    )
                ->where('o.id', $id)
                ->get()
                ->toArray();

            if(empty($promocode)){
                return Message::NOT_FOUND;
            }


            return $promocode[0];


        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }


    }

    public static function get_basket_products_data($products){
        $basket_ids = array_column($products, 'basket_id');

        try {
            $product_data = DB::table('order_products')
                ->select(
                    'product_id',
                    'price',
                    'discount_percent',
                    'discount_price'
                    )
                ->whereIn('id', $basket_ids)
                ->get()
                ->toArray();

            if(empty($product_data)){
                return Message::NOT_FOUND;
            }
            return $product_data;


        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }



    }


    public static function get_ccp_products_data($products){
        $ccp_ids = array_column($products, 'product_id');
        try {
            $product_data = DB::table('city_category_product as ccp')
                ->leftJoin('discounts as d', 'ccp.discount_id', '=', 'd.id')
                ->select(
                    'ccp.id as product_id',
                    'ccp.price',
                    'd.percent as discount_percent',
                    'd.price as discount_price'
                    )
                ->whereIn('ccp.id', $ccp_ids)
                ->get()
                ->toArray();

            if(empty($product_data)){
                return Message::NOT_FOUND;
            }
            return $product_data;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }

    public static function get_customer_data($id){

        try {
            $customer = DB::table('orders as o')
                ->join('customers as cst', 'o.customer_id', '=', 'cst.id')
                ->select(
                    'cst.id',
                    'cst.type_of_ownership_id'
                    )
                ->where('o.id', $id)
                ->get()
                ->toArray();

            if(empty($customer)){
                return Message::NOT_FOUND;
            }
            return $customer[0];

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }




    }


















}
