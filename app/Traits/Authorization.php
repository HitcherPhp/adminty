<?php


namespace App\Traits;

use App\Facades\Message;
use App\Http\Controllers\Adminty\ApiController;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\SessionModel;
use App\Facades\Auth;

trait Authorization
{

    private static $auth_code = [];


    public static function check_auth_code($attr) {


        if (isset($attr['code'])) {
            //Mail::to(static::$attr['email'])->send(new OrderShipped($order));

            if (strcmp(session()->get('code'), $attr['code']) === 0) {
                session()->forget('code');
                return 1;
            }

            return 0;
        }
    }


    public static function send_auth_code() {

        session()->put('code', (string)mt_rand(100000, 999999));

        return session()->get('code');

    }


    public static function registration($attr) {

        $id = static::register($attr);

        if (Message::SERVER_ERROR === $id) {
            return $id;
        }

        $login = Auth::loginUsingId($id);

        return $login;

    }

    public static function authorisation($attr) {

        $user = static::user_by_attr($attr);

        if($user === Auth::USER_NOT_FOUND) {
            return Auth::UNREGISTERED;
        }

        if (Message::SERVER_ERROR === $user) {
            return Message::SERVER_ERROR;
        }

        if(Hash::check($attr['password'], $user->password)) {

            $login = Auth::login($user);

            if (Auth::LOGIN_SUCCESS === $login) {
                return $login;
            }

            return Auth::LOGIN_ERROR;
        }
        else {
            return Auth::PASSWORD_ERROR;
        }

    }


    public static function logout() {

        $logout = Auth::logout();

        if (Auth::LOGOUT_SUCCESS === $logout) {
            return $logout;
        }

        return Auth::LOGOUT_ERROR;
    }


}
