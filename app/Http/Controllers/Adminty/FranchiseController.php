<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseModel;
use App\Models\OrganisationsAttributeModel;

class FranchiseController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request){
        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            return response()->json([
                    'headers' => OrganisationsAttributeModel::get_col_names(),
                    'table' => OrganisationsAttributeModel::get_first_franchises()
                ]);
        }else{
            return response()->json(['not valid request method']);
        }
    }

    public function update_table(Request $request){
        dd($request->all());
    }









}
