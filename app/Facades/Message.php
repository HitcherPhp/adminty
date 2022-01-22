<?php


namespace App\Facades;


class Message
{
    const IS_NOT_JSON = ['code' => 'NOT JSON'];
    const NOT_FOUND = ['code' => '404'];
    const VALIDATION_ERROR = ['code' => '406'];
    const SERVER_ERROR = ['code' => '500'];
    const SUCCESS = ['code' => 'OK'];
    const SESSION_LOADED = ['code' => 'SESSION LOADED'];
    const SESSION_UNLOADED = ['code' => 'SESSION UNLOADED'];

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

}
