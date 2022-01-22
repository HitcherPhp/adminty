<?php


namespace App\Facades;

use App\Models\CustomerModel;
use \App\Models\SessionModel;
use Exception;


class Session
{

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    private static $session;

    public static function current_session() {
        if (!isset(self::$session['session'])) {

            self::$session['session'] = SessionModel::where('id', '=', session()->getId())->first();

        }
        return self::$session['session'];
    }


    public static function save($attr)
    {
        try {

            if (self::current_session() === null) {
                return Message::SESSION_UNLOADED;
            }

            foreach ($attr as $key => $value) {

                if (self::current_session()->exists($key)) {

                    session()->put($key, $value);

                    self::current_session()->{$key} = $value;
                }
            }

            self::current_session()->save();

            return Message::SUCCESS;
        }
        catch (Exception $e) {

            return Message::SERVER_ERROR;
        }

    }

}
