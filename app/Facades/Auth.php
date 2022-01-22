<?php


namespace App\Facades;



use App\Facades\Session;
use App\Models\CustomerModel;
use App\Models\SessionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Auth
{

    const UNREGISTERED = 'Unregistered';
    const USER_NOT_FOUND = 'User not found';
    const LOGIN_ERROR = 'Unauthorized';
    const LOGIN_SUCCESS = 'Authorized';
    const PASSWORD_ERROR = 'Password error';
    const TOKEN_ERROR = 'Token error';
    const LOGOUT_SUCCESS = 'Logout';
    const LOGOUT_ERROR = 'Logout error';

    private static $user = [];

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


    private static function api_token() {

        $token = hash('sha256', Str::random(80));

        $count = CustomerModel::api_token_count($token);

        if ($count === Message::SERVER_ERROR) {
            return Message::SERVER_ERROR;
        }

        if (CustomerModel::api_token_count($token) === 0) {

            return $token;

        }
        else {
            self::api_token();
        }

    }


    public static function loginUsingId($id) {

        $token = self::api_token();

        if ($token === Message::SERVER_ERROR) {
            return Message::SERVER_ERROR;
        }

        $saved = Session::save(['api_token' => $token]);

        if ($saved === Message::SERVER_ERROR) {
            return Message::SERVER_ERROR;
        }

        $sat = CustomerModel::set_api_token($id);

        if ($sat === self::TOKEN_ERROR or $sat === Message::SERVER_ERROR) {
            return $sat;
        }

        if ($sat === self::TOKEN_ERROR or $sat === Message::SERVER_ERROR) {
            return $sat;
        }

        return Auth::LOGIN_SUCCESS;

    }


    public static function user() {

        if (!isset(self::$user['user'])) {

            try {


                self::$user['user'] = CustomerModel::current()->toArray();


                return self::$user['user'];

            }
            catch(\Exception $e) {
                return Message::SERVER_ERROR;
            }

        }
        return self::$user['user'];
    }


    public static function login($user) {


        $saved = Session::save(['api_token' => $user->api_token]);

        if ($saved === Message::SERVER_ERROR) {
            return Message::SERVER_ERROR;
        }

        return self::LOGIN_SUCCESS;

    }


    public static function logout() {

        self::$user = [];

        $saved = Session::save(['api_token' => null]);

        if ($saved === Message::SERVER_ERROR) {
            return Message::SERVER_ERROR;
        }

        return self::LOGOUT_SUCCESS;
    }

    public static function update($key, $value) {

        try {
            $user = CustomerModel::current();

            $user->{$key} = $value;

            $user->save();


            self::$user['user'] = $user->toArray();

            return Message::SUCCESS;

        }
        catch(\Exception $e) {
            return Message::SERVER_ERROR;
        }

    }

}
