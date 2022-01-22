<?php

namespace App\Models;

use App\Facades\Auth;
use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class SessionModel extends Model
{

    protected $table = 'sessions';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'api_token',
        'city_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];

}
