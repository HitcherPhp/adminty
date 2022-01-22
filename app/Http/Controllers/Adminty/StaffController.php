<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use App\Models\StaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\Validator;


class StaffController extends Controller
{

    public function __construct()
    {

    }


    public function index(Request $request){

        if($request->method() == 'GET'){
            return view('layouts/adminty');
        }
        else if($request->method() == 'POST'){
            # пусть присылается какое-нибудь булево значение
            # для того, чтобы знать, отправлять заголовки или нет
            return response()->json(
                # необходимо отправлять limit, bool массивом
                StaffModel::get_staff_table([])
            );
        }else{
            return response()->json(['not valid method']);
        }
    }


    public function update_table(Request $request)
    {
        dd($request->all());
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
                return response()->json(StaffModel::get_staff_member_data($data['id']));
            }
        }
    }



    public function create(Request $request)
    {
        // $email = $request->email;
        // $user = StaffModel::where('email', $email)->first();
        // if($user){
        //     return response()->json(false);
        // }
        // else{
        //     return response()->json(true);
        // }
        dd('create');
    }


    public function store(Request $request)
    {
        // if ($request->ajax()) {
        //     try{
        //         $data = $this->model->convert_staff_data($request -> all());
        //         // dd($data);
        //         $comment = 'Добро пожаловать в команду "Химчистка Leda".
        //         Для завершения регистрации пройдите по ссылке http://leda.hitcher.beget.tech/login , введя логин и пароль.
        //         Логин: '. $data['staff_email'] . ' Пароль: '. $data['password'];
        //         $toEmail = $data['staff_email'];
        //         Mail::to($toEmail)->send(new PasswordMail($comment));
        //     }catch(\Exception $e){
        //         return response()->json('Database error');
        //     }
        // }
        dd('store');
    }



    public function check_franchise_id(){
        // $userCollection = StaffModel::find(Auth::id());
        // $franchise = FranchiseModel::get_franchise_id_name($userCollection['id']);
        // if(count($franchise) == 0){
        //     return response()->json(-1);
        // }else{
        //     return response()->json($franchise);
        // }
        dd('check_franchise_id');
    }












}
