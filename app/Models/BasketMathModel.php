<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BasketMathModel extends Model
{
    public static function get_product_estimate_price($data){

        try {
            $price = DB::table('city_category_product')
                ->select(
                    'price',
                    'discount_percent',
                    'discount_price'
                    )
                ->where('id', $data['id'])
                ->get()
                ->toArray();


            if(empty($price)){
                return Message::NOT_FOUND;
            }

            // $estimate_price = bcmul($price[0]->price, $data['count'], 2);

            return self::math_product_estimate_price($price[0], $data['count']);


        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

    }

    public static function math_product_estimate_price($price, $count){
        $estimate_price = '';
        
        if($price->discount_percent === null){
            $estimate_price = bcmul($price->price, $count, 2);

        }else if($price->discount_price == 0 && $price->discount_percent != 0){
            $reverse_percent = bcsub(100, $price->discount_percent, 2);
            $decimal_percent = bcdiv($reverse_percent, 100, 2); // 0.89

            $price_with_percent = bcmul($price->price, $decimal_percent, 2);

            $estimate_price = bcmul($price_with_percent, $count, 2);

        }else if($price->discount_price != 0 && $price->discount_percent == 0){
            $price_with_discount = bcsub($price->price, $price->discount_price, 2);
            $estimate_price = bcmul($price_with_discount, $count, 2);

        }

        return [['estimate_price' => $estimate_price]];



    }


    // public static function math_basket_estimate_price($price, $count){
    //
    // }











}
