<?php

namespace App\Http\Controllers\Adminty;

use App\Facades\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SelectFranchiseModel;
use App\Models\LinkModel;
use App\Models\FranchiseModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdmintyController extends Controller
{
    public function __construct(){

    }

    public function navigation_links(){

        $links = LinkModel::links();

        if (Message::NOT_FOUND === $links) {
            return [];
        }

        return response($links);
    }

    public function get_franchises(){
        return response()->json(FranchiseModel::get_franchises());
    }

    public function update_franchise_in_db(Request $request){
        $data = $request->all();

        $rules = ['id' => 'required'];
        $messages = ['id.required' => 'there is no identificator'];

        $validator = Validator::make($data, $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }else{
            return SelectFranchiseModel::set_franchise($data['id']);
        }
    }

    public function get_current_user(){
        $user = Auth::user();

        return response()->json([
            // 'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }

















}
