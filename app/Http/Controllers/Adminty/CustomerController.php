<?php

namespace App\Http\Controllers\Adminty;


use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct()
    {

    }


    public function index(Request $request)
    {
        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            return response()->json(
                CustomerModel::check_before_send_first_customers()
            );
        }else{
            return response()->json(['not valid method']);
        }
    }

    public function categories(Request $request)
    {
        $column_names = [
            'Имя', 'Телефон', 'Почта', 'Клиент', 'Бонусные баллы', 'Партнерские баллы', 'Заказы'
        ];

        $main_categories = CategoryModel::main_categories();

        if ($main_categories) {
            return ['column_names' => $column_names, 'main_categories' => $main_categories];
        }

        return 'Not found';

    }

    public function edit(Request $request){
        if($request){
            $data = $request->all();
            $rules = ['id' => 'required'];
            $messages = ['id.required' => 'there is no identificator'];

            $validator = Validator::make($data, $rules, $messages);

            if($validator->fails()) {
                return $validator->errors();
            }else{
                return response()->json(CustomerModel::get_customer_data($data['id']));
            }
        }
    }


    public function update_table(Request $request)
    {
        dd($request->all());
    }
}
