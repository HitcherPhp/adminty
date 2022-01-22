<?php

namespace App\Models;

use App\Facades\Message;
use App\Facades\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderModel extends Model
{


    const CUSTOMER = 'customer';
    const PRODUCT = 'product';

    protected $table = 'orders';
    protected static $col_names = [
        [
            'text' => 'Номер заказа',
            'value' => 'name'
        ],
        [
            'text' => 'Клиент',
            'value' => 'customer_name'
        ],
        [
            'text' => 'Приемный пункт',
            'value' => 'reception_name'
        ]
    ];

    public static function get_col_names(){
        return self::$col_names;
    }

    public static function get_first_orders(){
        try {
            return DB::table('orders as ord')
            ->join('customers as cst', 'ord.customer_id', '=', 'cst.id')
            ->join('receptions as rec', 'ord.reception_id', '=', 'rec.id')
            ->join('addresses as adr', 'rec.address_id', '=', 'adr.id')
            ->select('ord.id', 'ord.number as name', 'cst.name as customer_name', 'adr.name as reception_name')
            ->where('ord.deleted', '=', 0)
            ->limit(10)
            ->orderBy('ord.id')
            ->get()
            ->toArray();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }




    public static function check_before_send_first_orders(){

        $headers = ['headers' => OrderModel::get_col_names()];
        $data = [
            'table' => OrderModel::get_first_orders(),
            'status_list' => StatusModel::get_statuses(),
            'payment_method_list' => PaymentMethodModel::get_payment_methods(),
        ];

        foreach ($data as $value) {
            if (Message::NOT_FOUND === $value) {
                return $value;
            }else if(Message::SERVER_ERROR === $value){
                return $value;
            }
        }
        $data = array_merge($headers, $data);
        return $data;
    }


    public static function search_autocomplete($data){
        switch ($data['column']) {
            case self::CUSTOMER:
                $customer = CustomerModel::search_customer($data['word']);
                if (Message::NOT_FOUND === $customer) {
                    return $customer;
                }else if(Message::SERVER_ERROR === $customer){
                    return $customer;
                }
                return $customer;
                break;
            case self::PRODUCT:
                // dd($data);

                // if(isset($data['basket_id'])){
                    // $product = OrderProductsModel::search_product_by_basketId($data);
                // }else if(isset($data['order_id'])){
                    $product = OrderModel::search_product_by_orderId($data);

                // }

                if (Message::NOT_FOUND === $product) {
                    return $product;
                }else if(Message::SERVER_ERROR === $product){
                    return $product;
                }
                return $product;

            default:
                return '{"message":"unknown column name"}';
                break;
        }
    }


    public static function search_product_by_orderId($data){

        try {
            $search = DB::table('orders as o')
                ->join('receptions as r', 'o.reception_id', '=', 'r.id')
                ->join('addresses as adr', 'r.address_id', '=', 'adr.id')
                ->join('city_category_product as ccp', 'adr.city_id', '=', 'ccp.city_id')
                ->join('products as p', 'ccp.product_id', '=', 'p.id')

                ->select(
                    'ccp.id as id',
                    'p.name',
                    'ccp.price'
                    )
                ->where([
                    ['o.id', $data['order_id']],
                    ['ccp.published', 1],
                    ['ccp.service_type_id', $data['service_type_id']],
                    ['p.name', 'like', '%' . $data['word'] . '%']
                ])
                ->get()
                ->toArray();

                if(empty($search)){
                    return Message::NOT_FOUND;
                }
            return $search;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }


    }


    public static function update_order_data($data){
        dd($data);
    }















}
