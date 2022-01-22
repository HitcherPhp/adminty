<?php

namespace App\Basket\Services;

use App\Basket\Models\OrderBasketEditQueriesModel;
use App\Facades\Message;

class BasketHandlerService
{

    private static $promocode = [];
    private static $was_in_basket = [];
    private static $was_not_in_basket = [];

    const DIGIT = -1;



    public static function bilding_estimate_products_data($data){

        // dd($data);

        $promocode = OrderBasketEditQueriesModel::get_promocode_data($data['id']);

        if(Message::NOT_FOUND === $promocode || Message::SERVER_ERROR === $promocode){
            return $promocode;
        }




        self::set_promocode($promocode);
        self::split_products($data['products']);


        $basket_products = self::get_was_in_basket();
        $ccp_products = self::get_was_not_in_basket();
        // dd($ccp_products);

        # нужна проверка на возвращенное значение (Message)
        $basket_products_data = OrderBasketEditQueriesModel::get_basket_products_data($basket_products);
        // dd($basket_products_data);

        $ccp_products_data = [];
        $actual_ccp_products = [];

        if(!empty($ccp_products)){
            $ccp_products_data = OrderBasketEditQueriesModel::get_ccp_products_data($ccp_products);
            $actual_ccp_products = self::add_count_basketId($ccp_products_data, $ccp_products);
        }

        $actual_basket_products = self::add_count_basketId($basket_products_data, $basket_products);

        /*
        *   $pre_products массив, с данными о продуктах (изначально содержащихся в корзине и добавленных при редактировании)
        *   количество, скидка, актуальная цена
        */
        $pre_products = array_merge($actual_basket_products, $actual_ccp_products);

        // $final_data = self::calculate_basket_data($data['id'], $pre_products);

        dd($pre_products);

        // dd($actual_basket_products, $actual_ccp_products);

    }

    public static function add_count_basketId($final, $base){
        $base = json_decode(json_encode($base));
        foreach ($final as $f_value) {
            foreach ($base as $b_value) {
                if($f_value->product_id == $b_value->product_id){
                    $f_value->count = $b_value->count;
                    $f_value->basket_id = $b_value->basket_id;
                }
            }
            unset($b_value);
        }
        unset($f_value);
        return $final;

    }


    public static function calculate_basket_data($id, $products){

        $promocode = self::get_promocode();


        if(empty($promocode)){
            return BasketMathService::calculate_without_promocode($products);
        }else{
            switch (self::DIGIT) {
                case $promocode->customer_ids != self::DIGIT:
                    $customer = OrderBasketEditQueriesModel::get_customer_data($id);
                    // if(Message::NOT_FOUND === $customer || Message::SERVER_ERROR === $customer){
                    //     return $customer;
                    // }
                    $t_f_o_ids = explode(',', $promocode->customer_ids);

                    if(in_array($customer->id, $t_f_o_ids)){
                        $calculated_products = BasketMathService::calculate_all_with_promocode($promocode, $products);

                    }else{
                        /*
                        * возможно вывести ошибку о том, что нельзя применять данный промокод
                        * когда корзина формируется (создание заказа)
                        * при редактировании (редактирование заказа) не должно выполняться условие else
                        */
                    }

                    return $calculated_products;

                case $promocode->type_of_ownership_ids != self::DIGIT:
                    $customer = OrderBasketEditQueriesModel::get_customer_data($id);
                    // if(Message::NOT_FOUND === $customer || Message::SERVER_ERROR === $customer){
                    //     return $customer;
                    // }
                    $t_f_o_ids = explode(',', $promocode->type_of_ownership_ids);

                    $calculated_products = [];
                    # из-за некорректных данных не выполняется in_array
                    # calculated_products должно формироваться внутри условия if(in_array...
                    $calculated_products = BasketMathService::calculate_all_with_promocode($promocode, $products);

                    if(in_array($customer->type_of_ownership_id, $t_f_o_ids)){
                        $calculated_products = BasketMathService::calculate_all_with_promocode($promocode, $products);

                    }else{
                        /*
                        * возможно вывести ошибку о том, что нельзя применять данный промокод
                        * когда корзина формируется (создание заказа)
                        * при редактировании (редактирование заказа) не должно выполняться условие else
                        */
                    }

                    // dd($type_of_ownership_ids);

                    return $calculated_products;


                case $promocode->category_ids != self::DIGIT:

                    return 'switch_case';

                case $promocode->product_ids != self::DIGIT:

                    return 'switch_case';

                default:
                    return 'default';
                    break;
            }

        }
    }

    /*
    *   разбивает массив продуктов по basket_id
    *   if basket_id == 0, значит продукт был добавлен при редактировании
    *   данные по нему нужно смотреть в city_category_product
    *   if basket_id != 0 продукт уже имелся в корзине
    *   данные по нему нужно смотреть в order_products
    */
    public static function split_products($data){

        $was_not_in_basket = array_filter($data, function($v){
            return $v['basket_id'] == 0;
        });

        $was_not_in_basket = array_values($was_not_in_basket);

        $was_in_basket = array_filter($data, function($v){
            return $v['basket_id'] != 0;
        });

        $was_in_basket = array_values($was_in_basket);

        self::set_was_not_in_basket($was_not_in_basket);
        self::set_was_in_basket($was_in_basket);

    }





    public static function set_was_in_basket($was_in_basket): void{
        self::$was_in_basket = $was_in_basket;
    }

    public static function get_was_in_basket(): array{
        return self::$was_in_basket;
    }

    public static function set_was_not_in_basket($was_not_in_basket): void{
        self::$was_not_in_basket = $was_not_in_basket;
    }

    public static function get_was_not_in_basket(): array{
        return self::$was_not_in_basket;
    }






    public static function set_promocode($promocode): void{
        if($promocode->id != null){
            self::$promocode = $promocode;
        }
    }

    public static function get_promocode(){
        return self::$promocode;
    }
}
