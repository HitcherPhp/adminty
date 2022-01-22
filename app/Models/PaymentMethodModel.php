<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Facades\Error;

class PaymentMethodModel extends Model
{
    protected $table = 'payment_methods';

    public $timestamps = false;

    public static function get_payment_methods()
    {
            try {
                return PaymentMethodModel::select('id', 'name')
                ->get()
                ->toArray();

            } catch (\Exception $e) {
                Log::channel('db_fail')->info($e);
                return Message::SERVER_ERROR;
            }

    }
}
