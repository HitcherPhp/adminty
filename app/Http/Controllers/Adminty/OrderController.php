<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\ActualProductModel;
use Illuminate\Support\Facades\Validator;
use App\Basket\Services\BasketBildingService;

class OrderController extends Controller
{

    public function __construct(){

    }

    public function index(Request $request){
        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            return response()->json(
                OrderModel::check_before_send_first_orders()
            );
        }else{
            return response()->json(['not valid method']);
        }
    }

    public function update_table(Request $request){
        dd($request->all());
    }


    public function edit(Request $request){
        $data = $request->all();
        // dd($data);
        $rules = [
            'id' => 'required',
            'need_service_headers' => 'required',
            'need_estimate_headers' => 'required',
         ];
        $messages = [
            'id.required' => 'there is no identificator',
            'need_service_headers.required' => 'expected bool parameter',
            'need_estimate_headers.required' => 'expected bool parameter'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }else{
            // return response()->json(OrderModel::get_order_data($data));
            return response()->json(BasketBildingService::assemble_basket_data($data));
        }
    }

    public function search_autocomplete(Request $request){
        $data = $request->all();
        // dd($data);


        $rules = ['column' => 'required', 'word' => 'required'];
        $messages = [
            'column.required' => 'there is no identificator',
            'word.required' => 'word is undefined'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }else{
            return response()->json(OrderModel::search_autocomplete($data));
        }
    }

    public function store(Request $request){
        $data = $request->all();
        # валидатор
        dd($data);
        OrderModel::update_order_data($data);
    }

    public function create(Request $request){
        dd($request->all());
        // if($request){
        //     return OrderModel::get_new_order();
        // }
    }


    public function get_added_product_data(Request $request){

        if($request){
            $data = $request->all();
            $rules = ['id' => 'required', 'count' => 'required'];
            $messages = [
                'id.required' => 'there is no identificator',
                'count.required' => 'there is no count'
            ];

            $validator = Validator::make($data, $rules, $messages);

            if($validator->fails()) {
                return $validator->errors();
            }else{
                return response()->json(ActualProductModel::get_added_product_data($data));
            }
        }
    }











}
