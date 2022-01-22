<?php

namespace App\Basket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Basket\Services\BasketBildingService;
use App\Facades\Message;
use App\Models\ServiceType;
use App\Models\CityModel;
use App\Models\OrderModel;



class OrderBasketQueriesModel extends Model
{
    /*
    * данная модель служит для запросов при открытии карточки
    */

    public static function get_order($id){
        try {
            $order_with_reception = DB::table('orders as o')
            ->join('customers as cst', 'o.customer_id', '=', 'cst.id')
            ->join('receptions as rec', 'o.reception_id', '=', 'rec.id')
            ->join('addresses as adr', 'rec.address_id', '=', 'adr.id')
            ->join('statuses_groups as s_g', 'o.id', '=', 's_g.order_id')
            ->join('statuses as S', 's_g.status_id', '=', 'S.id')
            ->leftJoin('promo_codes as p_c', 'o.promo_code_id', '=', 'p_c.id')
            ->join('payment_methods as p_m', 'o.payment_method_id', '=', 'p_m.id')

            ->select(
                'cst.id as customer_id',
                'cst.name as customer_name',
                'S.name as status_name',
                'p_c.name as promo_code_name',
                'p_c.discount_percent',
                'p_c.discount_price',
                'p_m.name as payment_method',
                'o.customer_comment',
                'o.estimate_price',
                'o.total_weight',
                'o.discount_sum',
                'o.delivery_price',
                'o.basket_price',
                'o.address_take_id',
                'o.address_return_id',

                'adr.city_id',
                'adr.address as reception_address',
                'adr.flat/office as reception_flat_office',
                'adr.name as reception_name',
                'adr.comment as reception_comment',
                'rec.phone as reception_contact',
                'rec.household'
                )
            ->where('o.id', '=', $id)
            ->get()
            ->toArray();

            if(empty($order_with_reception)){
                return Message::NOT_FOUND;
            }

            return $order_with_reception[0];

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }


    public static function get_service_type($data){
        try {
            $service_type = ServiceType::join('categories as c', 'service_type.main_category_id', '=', 'c.id')
                ->select('c.id as service_type_id', 'c.name as service_type')
                ->whereIn('alias', $data)
                ->get()
                ->toArray();
            if(empty($service_type)){
                return Message::NOT_FOUND;
            }
            return $service_type;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }


    public static function get_utc($city_id){
        try {
            $utc = CityModel::join('timezones as tz', 'timezone_id', '=', 'tz.id')
                ->select('tz.utc')
                ->where('cities.id' ,'=', $city_id)
                ->get()
                ->toArray();

            if(empty($utc)){
                return Message::NOT_FOUND;
            }
            return $utc[0]['utc'];

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }

    }


    public static function get_address_take($utc, $id){

        try {
            $address_take = OrderModel::join('addresses as adr', 'orders.address_take_id', '=', 'adr.id')
                ->select(
                    'adr.address as take_address',
                    'adr.flat/office as take_flat_office',
                    DB::raw("CONVERT_TZ(adr.date_time_from, '+00:00', '$utc') as take_date_time_from"),
                    DB::raw("CONVERT_TZ(adr.date_time_to, '+00:00', '$utc') as take_date_time_to"),
                    'adr.courier as take_courier_name'
                    )
                ->where('orders.id', '=', $id)
                ->get()
                ->toArray();

            if(empty($address_take)){
                return Message::NOT_FOUND;
            }

            return $address_take[0];

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Error::DB_SERVER_ERROR;
        }

    }

    public static function get_address_return($utc, $id){
        try {
            $address_return = OrderModel::join('addresses as adr', 'orders.address_return_id', '=', 'adr.id')
                ->select(
                    'adr.address as return_address',
                    'adr.flat/office as return_flat_office',
                    DB::raw("CONVERT_TZ(adr.date_time_from, '+00:00', '$utc') as return_date_time_from"),
                    DB::raw("CONVERT_TZ(adr.date_time_to, '+00:00', '$utc') as return_date_time_to"),
                    'adr.courier as return_courier_name'
                    )
                ->where('orders.id', '=', $id)
                ->get()
                ->toArray();

            if(empty($address_return)){
                return Message::NOT_FOUND;
            }
            return $address_return[0];

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }



    public static function get_order_products($order_id, $city_id){
        
        try {
            $product_data = DB::table('order_products as o_p')
            ->join('city_category_product as ccp', 'o_p.product_id', '=', 'ccp.id')
            ->join('products as p', 'ccp.product_id', '=', 'p.id')
            ->join('categories as c', 'ccp.category_id', '=', 'c.id')
            // ->join('service_type as s_t', DB::raw("find_in_set(s_t.main_category_id, c.parent_ids) <> 0 or s_t.main_category_id"), '=', 'c.id')
            ->join('service_type as s_t', 'ccp.service_type_id', '=', 's_t.id')
            ->select(
                'o_p.id as basket_id',
                'ccp.service_type_id',
                's_t.name as service_type',
                'ccp.id as product_id',
                'p.name as product_name',
                'c.id as category_id',
                'c.name as category_name',
                'o_p.count',
                'o_p.price',
                'o_p.estimate_price',
                'o_p.discount_percent',
                'o_p.discount_price',
                )
                ->where([
                    ['o_p.order_id', '=', $order_id],
                    ['ccp.city_id', '=', $city_id]
                ])
                ->get()
                ->toArray();

                if(empty($product_data)){
                    return Message::NOT_FOUND;
                }

                return BasketBildingService::convert_discount_data($product_data);

            } catch (\Exception $e) {
                Log::channel('db_fail')->info($e);
                return Message::SERVER_ERROR;
            }
    }



}
