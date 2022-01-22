<?php

namespace App\Basket\Services;

use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Exception;

class BasketBildingService
{

    // const PERCENT = 'percent';
    // const CURRENCY = 'currency';

    const ICON_PERCENT = 'mdi-percent';
    const ICON_CURRENCY = 'mdi-cash-multiple';


    public static function assemble_basket_data($data){

        $id = $data['id'];
        $bool_service = $data['need_service_headers'];
        $bool_estimate = $data['need_estimate_headers'];

        $basket = GetBasketService::getInstance();

        $bool = $basket->check_order_id($id);
        // добавить проверку если какое-нибудь из сохраненных значений == Message:: "..."

        if(!$bool){
            $order = $basket->get_order($id);
            $service_type = $basket->get_service_type($id);
            $address_take = $basket->get_address_take($id);
            $address_return = $basket->get_address_return($id);
            $order_products = $basket->get_order_products($id);
        }
        else{
            $order = $basket::get_self_order();
            $service_type = $basket::get_self_service_type();
            $address_take = $basket::get_self_address_take();
            $address_return = $basket::get_self_address_return();
            $order_products = $basket::get_self_order_products();
        }
        // $d = Permission::permissions();
        // dd($d);
        // $order = $basket::get_self_order();
        // dd($order);

        $order_collection = collect([
            ['order' => $order],
            ['service_types' => $service_type],
            ['address_take' => $address_take],
            ['address_return' => $address_return],
            ['order_products' => $order_products]
        ]);


        $collapsed = $order_collection->collapse();

        foreach ($collapsed->all() as $value) {
            if (Message::NOT_FOUND === $value || Message::SERVER_ERROR === $value) {
                return $value;
            }

        }
        unset($value);
        // dd($collapsed->all());

        return self::prepare_to_send_basket($collapsed->all(), $bool_service, $bool_estimate);
        // return $collapsed->all();
    }

    public static function prepare_to_send_basket($data, $bool_service, $bool_estimate){

        $temp = self::convert_discount_data([$data['order']]);
        $data['order'] = $temp[0];

        $order_for_send = GetBasketService::get_new_order();

        $customer_data = json_decode(json_encode([
            'id' => $data['order']->customer_id,
            'name' => $data['order']->customer_name
        ]));

        $order_for_send['details'][0]['data'] = $customer_data;
        $order_for_send['details'][0]['items'] = [$customer_data];

        $order_for_send['details'][1]['data'] = $data['order']->status_name;
        $order_for_send['details'][2]['data'] = $data['order']->promo_code_name;

        $order_for_send['details'][3]['data'] = $data['order']->discount;
        $order_for_send['details'][3]['icon'] = $data['order']->discount_icon;

        $order_for_send['details'][4]['data'] = $data['order']->payment_method;
        $order_for_send['details'][5]['data'] = $data['order']->customer_comment;


        $order_for_send['service'] = $data['order_products'];

        $order_for_send['service_types'] = $data['service_types'];

        if($bool_service){
            $order_for_send['service_headers'] = GetBasketService::get_service_headers();
        }

        if($bool_estimate){
            $order_for_send['estimate_headers'] = GetBasketService::get_estimate_headers();
        }

        $order_for_send['reception_data'][0]['data'] = $data['order']->reception_name;
        $order_for_send['reception_data'][1]['data'] = $data['order']->reception_address;
        $order_for_send['reception_data'][2]['data'] = $data['order']->reception_flat_office;
        $order_for_send['reception_data'][3]['data'] = $data['order']->reception_contact;
        $order_for_send['reception_data'][4]['data'] = $data['order']->reception_comment;

        $order_for_send['estimate_data'][0]['data'] = $data['order']->total_weight;
        $order_for_send['estimate_data'][1]['data'] = $data['order']->basket_price;
        $order_for_send['estimate_data'][2]['data'] = $data['order']->discount_sum;
        $order_for_send['estimate_data'][3]['data'] = $data['order']->delivery_price;
        $order_for_send['estimate_data'][4]['data'] = $data['order']->estimate_price;


        if($data['address_take']){

            $order_for_send['addresses'][0][0]['data'] = $data['address_take']['take_address'];
            $order_for_send['addresses'][0][1]['data'] = $data['address_take']['take_flat_office'];
            $order_for_send['addresses'][0][2]['data'] = $data['address_take']['take_date_time_from'];
            $order_for_send['addresses'][0][3]['data'] = $data['address_take']['take_date_time_to'];
            $order_for_send['addresses'][0][4]['data'] = $data['address_take']['take_courier_name'];

            $order_for_send['addresses'][1][0]['data'] = $data['address_return']['return_address'];
            $order_for_send['addresses'][1][1]['data'] = $data['address_return']['return_flat_office'];
            $order_for_send['addresses'][1][2]['data'] = $data['address_return']['return_date_time_from'];
            $order_for_send['addresses'][1][3]['data'] = $data['address_return']['return_date_time_to'];
            $order_for_send['addresses'][1][4]['data'] = $data['address_return']['return_courier_name'];


        }else{
            $order_for_send['addresses'] = false;

        }
        // dd($order_for_send);

        return $order_for_send;

    }

    public static function convert_discount_data($data){
        foreach ($data as $value) {
            if($value->discount_percent === null || $value->discount_price === null){
                $value->discount = '';
                $value->discount_icon = '';

            }else if($value->discount_percent == 0){
                $value->discount = $value->discount_price;
                $value->discount_icon = self::ICON_CURRENCY;
            }else{
                $value->discount = $value->discount_percent;
                $value->discount_icon = self::ICON_PERCENT;
            }
            unset($value->discount_percent);
            unset($value->discount_price);
        }
        return $data;
    }

}
