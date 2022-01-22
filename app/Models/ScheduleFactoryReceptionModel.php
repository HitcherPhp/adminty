<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScheduleFactoryReceptionModel extends Model
{
    protected $table='schedule_factory_reception';

    public static function insert_get_id($data) {

        $last_schedule_id = DB::table('schedule_factory_reception')->insertGetId($data);
        return $last_schedule_id;

    }







}
