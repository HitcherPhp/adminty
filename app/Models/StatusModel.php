<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Facades\Error;

class StatusModel extends Model
{
    protected $table='statuses';

    public $timestamps = false;

    public static function get_statuses(){
        try {
            $statuses = StatusModel::select('id', 'name')->get()->toArray();
            return $statuses;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }




}
