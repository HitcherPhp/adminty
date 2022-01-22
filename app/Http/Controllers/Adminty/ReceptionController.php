<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReceptionModel;

class ReceptionController extends Controller
{
    public function index(Request $request){
        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            return response()->json([
                    'headers' => ReceptionModel::get_col_names(),
                    'table' => ReceptionModel::get_first_receptions()
                ]);
        }else{
            return response()->json(['not valid request method']);
        }
    }

    public function update_table(Request $request){
        dd($request->all());
    }
}
