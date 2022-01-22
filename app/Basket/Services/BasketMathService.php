<?php

namespace App\Basket\Services;

class BasketMathService
{

    const ICON_PERCENT = 'mdi-percent';
    const ICON_CURRENCY = 'mdi-cash-multiple';

    public static function calculate_without_promocode($products){
        dd('calculate_without_promocode', $products);






    }


    public static function calculate_all_with_promocode($promocode, $products){

        dd($promocode, $products);

        // $d = self::promocode_price($products);
        // dd($d);
        if($promocode->discount_percent != 0){

        }
        else if($promocode->discount_price != 0 ){

            self::promocode_price($products, $promocode->discount_price);
        }



    }

    public static function promocode_price($products, $p_c_price){

        foreach ($products as $value) {
            if($value->discount_price === null){

                $value->discount = $p_c_price;
                $value->discount_icon = self::ICON_CURRENCY;
                $value->product_with_discount = bcsub($value->price, $p_c_price, 2);
                $value->estimate_product_price = bcmul($value->product_with_discount, $value->count, 2);

            }else if($value->discount_price != 0){
                if ($value->discount_price > $p_c_price){

                    $value->discount = $value->discount_price;
                    $value->discount_icon = self::ICON_CURRENCY;
                    $value->product_with_discount = bcsub($value->price, $value->discount_price, 2);
                    $value->estimate_product_price = bcmul($value->product_with_discount, $value->count, 2);

                }else{
                    $value->discount = $p_c_price;
                    $value->discount_icon = self::ICON_CURRENCY;
                    $value->product_with_discount = bcsub($value->price, $p_c_price, 2);
                    $value->estimate_product_price = bcmul($value->product_with_discount, $value->count, 2);

                }
            }else if($value->discount_percent != 0){
                



            }
            unset($value->discount_percent);
            unset($value->discount_price);
        }
        unset($value);

        return $products;

    }








}
