<?php

namespace App\Basket\Services;

use App\Basket\Models\OrderBasketModel;
use Illuminate\Support\Facades\Log;
use App\Facades\Message;
use App\Basket\Models\OrderBasketQueriesModel;

class GetBasketService
{

    protected static $_instance;

    const CUSTOMER = 'customer';
    const PRODUCT = 'product';

    private static $order = null;
    private static $order_id = null;

    protected static $with_household = [
        'himchistka',
        'krashenie',
        'hranenie',
        'remont '
    ];
    protected static $without_household = ['himchistka'];
    protected static $aliases = [];
    protected static $utc = null;

    protected static $service_type = null;
    protected static $address_take = false;
    protected static $address_return = false;
    protected static $order_products = null;

    protected static $new_order = [
        'details' => [
            [
                'text' => 'Выбор клиента (замена)',
                'type' => 'autocomplete',
                'data' => '',
                'column' => self::CUSTOMER,
                'search' => '',
                'items' => []
            ],
            [
                'text' => 'Выбор статуса заказа',
                'type' => 'select',
                'data' => '',
                'key' => 'status_list'
            ],
            [
                'text' => 'Имя промокода',
                'type' => 'inputReedOnly',
                'data' => ''
            ],
            [
                'text' => 'Число промокода',
                'type' => 'inputReedOnly',
                'data' => '',
                'icon' => ''
            ],
            [
                'text' => 'Способ оплаты',
                'type' => 'select',
                'data' => '',
                'key' => 'payment_method_list'
            ],
            [
                'text' => 'Комментарий',
                'type' => 'textArea',
                'data' => ''
            ]
        ],
        'addresses' =>[
            [
                [
                    'text' => 'Улица, дом',
                    'type' => 'input',
                    'data' => ''
                ],
                [
                    'text' => 'Квартира\офис',
                    'type' => 'input',
                    'data' => ''
                ],
                [
                    'text' => 'Дата и время',
                    'type' => 'datePicker',
                    'data' => ''
                ],
                [
                    'text' => 'Дата и время',
                    'type' => 'datePicker',
                    'data' => ''
                ],
                [
                    'text' => 'Имя курьера',
                    'type' => 'inputReedOnly',
                    'data' => ''
                ]
            ],
            [
                [
                    'text' => 'Улица, дом',
                    'type' => 'input',
                    'data' => ''
                ],
                [
                    'text' => 'Квартира\офис',
                    'type' => 'input',
                    'data' => ''
                ],
                [
                    'text' => 'Дата и время',
                    'type' => 'datePicker',
                    'data' => ''
                ],
                [
                    'text' => 'Дата и время',
                    'type' => 'datePicker',
                    'data' => ''
                ],
                [
                    'text' => 'Имя курьера',
                    'type' => 'inputReedOnly',
                    'data' => ''
                ]
            ]
        ],
        'service' => [],
        'service_headers' => false,
        'estimate_headers' => false,
        'service_types' => [],
        'estimate_data' => [
            [
                'data' => '',
                'key' => 'total_weight'
            ],
            [
                'data' => '',
                'key' => 'basket_price'
            ],
            [
                'data' => '',
                'key' => 'discount_sum'
            ],
            [
                'data' => '',
                'key' => 'delivery_price'
            ],
            [
                'data' => '',
                'key' => 'estimate_price'
            ],
        ],
        'reception_data' => [
            [
                'text' => 'Имя приемного пункта',
                'type' => 'input',
                'data' => ''
            ],
            [
                'text' => 'Адрес приемного пункта',
                'type' => 'input',
                'data' => ''
            ],
            [
                'text' => 'Номер офиса приемного пункта',
                'type' => 'input',
                'data' => ''
            ],
            [
                'text' => 'Телефон приемного пункта',
                'type' => 'input',
                'data' => ''
            ],
            [
                'text' => 'Описание приемного пункта',
                'type' => 'input',
                'data' => ''
            ]
        ]
    ];

    protected static $service_headers = [
        [
            'text' => 'Наимевание услуги',
            'value' => 'service_type'
        ],
        [
            'text' => 'Товар',
            'value' => 'product_name'
        ],
        [
            'text' => 'Категория',
            'value' => 'category_name'
        ],
        [
            'text' => 'Цена',
            'value' => 'price'
        ],
        [
            'text' => 'Скидка',
            'value' => 'discount'
        ],
        [
            'text' => 'Кол-во',
            'value' => 'count'
        ],
        [
            'text' => 'Сумма',
            'value' => 'estimate_price'
        ],
    ];

    protected static $estimate_headers = [
        ['header' => 'Вес всех вещей: '],
        ['header' => 'Сумма заказа: '],
        ['header' => 'Сумма скидки: '],
        ['header' => 'Доставка: '],
        ['header' => 'Итого: '],
    ];

    protected function __construct() {}

    # вызывать данный метод для получения экземпляра класса
    public static function getInstance(): self {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }


    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


    public function get_order($id){
        try {
            $order = OrderBasketQueriesModel::get_order($id);

            self::set_self_order($order);
            self::set_order_id($id);
            self::set_aliases();
            self::set_utc($order);

            return self::get_self_order();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }


    }

    public function get_service_type($id){
        try {
            $aliases = self::get_aliases();
            $service_type = OrderBasketQueriesModel::get_service_type($aliases);
            self::set_service_type($service_type);

            return self::get_self_service_type();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }




    }

    public function set_utc($order){
        try {
            $utc = OrderBasketQueriesModel::get_utc($order->city_id);
            self::$utc = $utc;
        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }


    }

    public function get_address_take($id){
        try {
            $order = self::get_self_order();

            if($order->address_take_id !== null){
                $utc = self::get_self_utc();
                $address_take = OrderBasketQueriesModel::get_address_take($utc, $id);

                self::set_address_take($address_take);
            }else{
                self::set_address_take(false);
            }

            return self::get_self_address_take();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }


    }

    public function get_address_return($id){
        try {
            $order = self::get_self_order();

            if($order->address_return_id !== null){
                $utc = self::get_self_utc();
                $address_return = OrderBasketQueriesModel::get_address_return($utc, $id);
                self::set_address_return($address_return);

            }else{
                self::set_address_return(false);
            }

            return self::get_self_address_return();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;

        }


    }

    public function get_order_products($id){
        try {
            $order = self::get_self_order();
            $order_products = OrderBasketQueriesModel::get_order_products($id, $order->city_id);

            self::set_order_products($order_products);
            return self::get_self_order_products();

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }


    }

    public static function check_order_id($id): bool{
        if(self::$order_id === $id){
            return true;
        }else{
            return false;
        }
    }

    public static function set_address_take($address_take){
        self::$address_take = $address_take;
    }

    public static function get_self_address_take(){
        return self::$address_take;
    }

    public static function set_address_return($address_return){
        self::$address_return = $address_return;
    }

    public static function get_self_address_return(){
        return self::$address_return;
    }

    public static function set_order_products($order_products){
        self::$order_products = $order_products;
    }

    public static function get_self_order_products(){
        return self::$order_products;
    }

    // public static function set_utc($utc){
    //     self::$utc = $utc;
    // }

    public static function get_self_utc(){
        return self::$utc;
    }

    public static function set_service_type($service_type){
        self::$service_type = $service_type;
    }

    public static function get_self_service_type(){
        return self::$service_type;
    }

    public static function set_aliases(): void{
        try {
            $order = self::get_self_order();
            if($order->household == 0){
                self::$aliases = self::$without_household;
            }else{
                self::$aliases = self::$with_household;
            }
        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            self::$aliases = Message::SERVER_ERROR;
        }


    }

    public static function get_new_order(){
        return self::$new_order;
    }

    public static function get_aliases(): array{
        return self::$aliases;
    }


    public static function set_order_id($id): void{
        self::$order_id = $id;
    }



    public static function get_self_order(){
        return self::$order;
    }

    public static function set_self_order($order): void{
        self::$order = $order;
    }

    public static function get_service_headers(){
        return self::$service_headers;
    }

    public static function get_estimate_headers(){
        return self::$estimate_headers;
    }












}
