<?php


namespace App\Basket\Controllers;

use App\Basket\Events\BasketListEvent;
use App\Basket\Services\BasketAdapterService;
use App\Basket\Services\ActualBasketService;
use App\Basket\Services\BasketBildingService;
use App\Basket\Services\BasketHandlerService;
use App\Facades\Message;
use App\Http\Controllers\Controller;
use App\Models\ActualProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BasketController extends Controller
{

    public function get_basket(Request $request) {

        $event = event(new BasketListEvent($request->only('products')));

        $response = $event[0];

        return response()->json($response);
    }

    public function get_basket_estimate_price(Request $request){

        BasketHandlerService::bilding_estimate_products_data($request->all());
        dd($request->all());
        if($request){
            // $data = $request->all();
            // $rules = ['id' => 'required', 'count' => 'required'];
            // $messages = [
            //     'id.required' => 'there is no identificator',
            //     'count.required' => 'there is no count'
            // ];
            //
            // $validator = Validator::make($data, $rules, $messages);
            //
            // if($validator->fails()) {
            //     return $validator->errors();
            // }else{
            //     return response()->json(BasketMathModel::get_product_estimate_price($data));
            // }
        }
    }
}
