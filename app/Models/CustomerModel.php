<?php

namespace App\Models;


use App\Facades\Auth;
use App\Facades\Message;
use App\Traits\Authorization;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerModel extends Model
{
    use Authorization;

    protected $table = 'customers';
    protected static $col_names = [
        [
            'text' => 'Имя',
            'value' => 'name'
        ],
        [
            'text' => 'Телефон',
            'value' => 'customer_phone'
        ],
        [
            'text' => 'Почта',
            'value' => 'customer_email'
        ],
        [
            'text' => 'Право собственности',
            'value' => 'type_of_ownership'
        ]

    ];

    public static function get_col_names(){
        return self::$col_names;
    }

    public function scopeCurrent($query) {

            return $query->from('customers as cms')->select(
                'cms.id as id',
                'cms.name as name',
                'cms.birthday as birthday',
                'cms.gender as gender',
                'cms.phone as phone',
                'cms.email as email',
                'too.name as type_of_ownership'
            )
                ->join('type_of_ownerships as too','too.id', '=', 'cms.type_of_ownership_id')
                ->where('cms.api_token', '=', session()->get('api_token'))->first();
    }



    public static function user_by_attr($attr) {

        try {

            $query = DB::table('customers as c');

            if(isset($attr['phone'])) {

                $query->where('c.phone', '=', $attr['phone']);
            }
            elseif(isset($attr['email'])) {
                $query->where('c.email', '=', $attr['email']);
            }

            $user = $query->first();

            if ($user === null) {
                return Auth::USER_NOT_FOUND;
            }

            return $user;

        }
        catch (Exception $e) {

            return Message::SERVER_ERROR;
        }

    }


    public static function api_token_count($token) {

        try {

            return DB::table('customers as c')->where('c.api_token', '=', $token)->count();

        }
        catch (Exception $e) {

            return Message::SERVER_ERROR;
        }

    }


    public static function set_api_token($id){
        try {

            if (!session()->has('api_token')) {

                return Auth::LOGIN_ERROR;
            }

            return DB::table('customers as c')
                ->where('c.id', '=', $id)
                ->update([
                'c.api_token' => session('api_token')
                ]);

        }
        catch (Exception $e) {

            return Message::SERVER_ERROR;
        }
    }


    private static function register($attr){
        try {

            return DB::table('customers')->insertGetId([
                'name' => $attr['name'],
                'phone' => $attr['phone'],
                'phone_verified_at' => DB::raw("NOW()"),
                'password' => Hash::make($attr['password']),
                'created_at' => DB::raw("NOW()"),
            ]);

        }
        catch (Exception $e) {

            return Message::SERVER_ERROR;
        }
    }

    public static function search_customer($word){

        try {
            return CustomerModel::select('id', 'name', 'phone')
            ->where([['name', 'like', '%' . $word . '%'], ['deleted', '=', 0]])
            ->get()
            ->toArray();

        } catch (\Exception $e) {

            return Message::SERVER_ERROR;
        }


    }

    public static function get_fcustomers_table(){

        try {
            $customer = DB::table('customers as cs')->join('type_of_ownerships as too', 'cs.type_of_ownership_id', '=', 'too.id')
                ->select(
                    'cs.id',
                    'cs.name',
                    'cs.phone as customer_phone',
                    'cs.email as customer_email',
                    'too.name as type_of_ownership'
                )
                ->where('cs.deleted', '=', 0)
                ->limit(10)
                ->orderBy('cs.id')
                ->get()
                ->toArray();
            if(empty($customer)){
                return Message::NOT_FOUND;
            }
            return $customer;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }


    }







    public static function check_before_send_first_customers(){
        $headers = ['headers' => CustomerModel::get_col_names()];

        $first_customers = self::get_first_customers();

        if (Message::NOT_FOUND === $first_customers) {
            return $first_customers;
        }else if(Message::SERVER_ERROR === $first_customers){
            return $first_customers;
        }

        $data = array_merge($headers, ['table' => $first_customers]);
        return $data;
    }


    public static function get_customer_data($id){
        try {
            $certain_customer = DB::table('customers as cs')->join('type_of_ownerships as too', 'cs.type_of_ownership_id', '=', 'too.id')
                ->select(
                    'cs.id',
                    'cs.name',
                    'cs.phone as customer_phone',
                    'cs.email as customer_email',
                    'too.name as type_of_ownership'
                    )
                ->where('cs.id', '=', $id)
                ->get()
                ->toArray();

            if(empty($certain_customer)){
                return Message::NOT_FOUND;
            }
            return $certain_customer;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

    }







}
