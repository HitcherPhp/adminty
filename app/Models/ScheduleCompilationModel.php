<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScheduleCompilationModel extends Model
{
    protected $table='schedule_compilation';
    protected static $schedule_compilation = [];

    public static function insert_only($data) {

        DB::table('schedule_compilation')->insert($data);

    }
    public static function collect_schedule_data($data, $id){

        foreach ($data as $value) {
            array_push(self::$schedule_compilation, ['schedule_id' => $id, 'schedule_day_time_id' => $value['day_time_id']]);
        }
        self::insert_only(self::$schedule_compilation);
    }
}
