<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FactoryModel;
use Illuminate\Support\Facades\Validator;

class FactoryController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request){
        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            return response()->json(
                FactoryModel::check_before_send_first_factories()
            );
        }else{
            return response()->json(['not valid request method']);
        }
    }

    public function update_table(Request $request){
        dd($request->all());
    }

    public function edit(Request $request){
        $data = $request->all();
        $rules = ['id' => 'required'];
        $messages = ['id.required' => 'there is no identificator'];

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }else{
            return response()->json(FactoryModel::get_factory_data($data['id']));
        }
    }









}
