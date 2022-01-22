<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScheduleDayTimeModel extends Model
{
    protected $table='schedule_day_time';
    protected static $day_time_array = [];
    protected static $stock_schedule_data = [];
    protected static $new_schedule_data = [];
    protected static $all_days = [1, 2, 3, 4, 5, 6, 7];
    protected static $utc_time = '';

    public static function insert_get_id($data) {
        $last_day_time_id = DB::table('schedule_day_time')->insertGetId($data);
        return $last_day_time_id;
    }

    public static function to_greenwich_utc($data){
        $time_block = [
            'workday' => [
                ['value' => ''],
                ['value' => ''],
            ],
            'break' => [
                ['value' => ''],
                ['value' => ''],
            ],
            'checkbox' => [],
        ];
        // dd(json_decode(json_encode($time_block)));
        // $time_block = json_decode(json_encode($time_block));

        if (self::$utc_time[0] == '-'){
            str_replace('-', '', self::$utc_time);
            $utc_time = -strtotime(self::$utc_time);
        }else{
            $utc_time = strtotime(self::$utc_time);
        }
        // dd($data);
        foreach ($data as $one_block) {

            $workday_from = strtotime($one_block->workday[0]->value);
            $workday_to = strtotime($one_block->workday[1]->value);
            $break_from = strtotime($one_block->break[0]->value);
            $break_to = strtotime($one_block->break[1]->value);

            # время от полуночи в минутах
            $gap_workday_from = ($workday_from - $utc_time) / 60;
            $gap_workday_to = ($workday_to - $utc_time) / 60;
            $gap_break_from = ($break_from - $utc_time) / 60;
            $gap_break_to = ($break_to - $utc_time) / 60;

            if($utc_time > 0){
                if($gap_workday_from < 0){
                    for ($i=0; $i < 2; $i++) {
                        array_push(self::$new_schedule_data, $time_block);
                        $len = count(self::$new_schedule_data);
                        foreach ($one_block->checkbox as $day) {
                            $count = $day->count + $i;
                            if($count > 7){
                                $count = 1;
                            }
                            array_push(self::$new_schedule_data[$len - 1]['checkbox'], ['count' => $count]);
                        }
                        unset($day);
                    }

                    if($gap_break_from >= 0 && $gap_break_to > 0){
                        if(fmod($gap_workday_from, 60)){
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod(abs($gap_workday_from), 60));
                        }else{
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (24 - intdiv(abs($gap_workday_from), 60)).':00';
                        }
                        self::$new_schedule_data[$len - 2]['workday'][1]['value'] = '00:00';
                        self::$new_schedule_data[$len - 2]['break'][0]['value'] = intdiv(abs($gap_break_from), 60).':'.fmod(abs($gap_break_from), 60);
                        self::$new_schedule_data[$len - 2]['break'][1]['value'] = intdiv(abs($gap_break_to), 60).':'.fmod(abs($gap_break_to), 60);
                        self::$new_schedule_data[$len - 1]['workday'][0]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['workday'][1]['value'] = intdiv(abs($gap_workday_to), 60).':'.fmod(abs($gap_workday_to), 60);
                        self::$new_schedule_data[$len - 1]['break'][0]['value'] = intdiv(abs($gap_break_from), 60).':'.fmod(abs($gap_break_from), 60);
                        self::$new_schedule_data[$len - 1]['break'][1]['value'] = intdiv(abs($gap_break_to), 60).':'.fmod(abs($gap_break_to), 60);
                        // print_r('first____');

                    }
                    if($gap_break_from < 0 && $gap_break_to > 0 ){
                        if(fmod(abs($gap_workday_from), 60)){
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod(abs($gap_workday_from), 60));
                        }else{
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (24 - intdiv(abs($gap_workday_from), 60)).':00';
                        }
                        if(fmod(abs($gap_break_from), 60)){
                            self::$new_schedule_data[$len - 2]['break'][0]['value'] =(23 - intdiv(abs($gap_break_from), 60)).':'.(60 - fmod(abs($gap_break_from), 60));
                        }else{
                            self::$new_schedule_data[$len - 2]['break'][0]['value'] =(24 - intdiv(abs($gap_break_from), 60)).':00';
                        }

                        self::$new_schedule_data[$len - 2]['workday'][1]['value'] = '00:00';
                        self::$new_schedule_data[$len - 2]['break'][1]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['workday'][0]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['workday'][1]['value'] = intdiv(abs($gap_workday_to), 60).':'.fmod(abs($gap_workday_to), 60);
                        self::$new_schedule_data[$len - 1]['break'][0]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['break'][1]['value'] = intdiv(abs($gap_break_to), 60).':'.fmod(abs($gap_break_to), 60);
                        // print_r('second');
                    }
                    if($gap_break_from < 0 && $gap_break_to <= 0){
                        if(fmod(abs($gap_workday_from), 60)){
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod(abs($gap_workday_from), 60));
                        }else{
                            self::$new_schedule_data[$len - 2]['workday'][0]['value'] = (24 - intdiv(abs($gap_workday_from), 60)).':00';
                        }
                        if(fmod(abs($gap_break_from), 60)){
                            self::$new_schedule_data[$len - 2]['break'][0]['value'] =(23 - intdiv(abs($gap_break_from), 60)).':'.(60 - fmod(abs($gap_break_from), 60));
                        }else{
                            self::$new_schedule_data[$len - 2]['break'][0]['value'] =(24 - intdiv(abs($gap_break_from), 60)).':00';
                        }
                        if(fmod(abs($gap_break_to), 60)){
                            self::$new_schedule_data[$len - 2]['break'][1]['value'] = (23 - intdiv(abs($gap_break_to), 60)).':'.(60 - fmod(abs($gap_break_to), 60));
                        }else{
                            if(intdiv(abs($gap_break_to), 60) == 0){
                                self::$new_schedule_data[$len - 2]['break'][1]['value'] = '00:00';
                            }else{
                                self::$new_schedule_data[$len - 2]['break'][1]['value'] = (24 - intdiv(abs($gap_break_to), 60)).':00';
                            }
                        }


                        self::$new_schedule_data[$len - 2]['workday'][1]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['workday'][0]['value'] = '00:00';
                        self::$new_schedule_data[$len - 1]['workday'][1]['value'] = intdiv(abs($gap_workday_to), 60).':'.fmod(abs($gap_workday_to), 60);
                        self::$new_schedule_data[$len - 1]['break'][0]['value'] = NULL;
                        self::$new_schedule_data[$len - 1]['break'][1]['value'] = NULL;
                        // print_r('third');
                    }

                }
                else{
                    $len = count(self::$new_schedule_data);
                    array_push(self::$new_schedule_data, $one_block);
                    if(fmod($gap_workday_from, 60)){
                        self::$new_schedule_data[$len]->workday[0]->value = (intdiv($gap_workday_from, 60)).':'.fmod($gap_workday_from, 60);
                    }else{
                        self::$new_schedule_data[$len]->workday[0]->value = (intdiv($gap_workday_from, 60)).':00';
                    }
                    self::$new_schedule_data[$len]->workday[1]->value = intdiv($gap_workday_to, 60).':'.fmod($gap_workday_to, 60);
                    self::$new_schedule_data[$len]->break[0]->value = intdiv($gap_break_from, 60).':'.fmod($gap_break_from, 60);
                    self::$new_schedule_data[$len]->break[1]->value = intdiv($gap_break_to, 60).':'.fmod($gap_break_to, 60);
                    // dd(self::$new_schedule_data);

                }
            }
            // else{
            //     if($gap_workday_to > 0){
            //         for ($i=0; $i < 2; $i++) {
            //             array_push(self::$new_schedule_data, $time_block);
            //             $len = count(self::$new_schedule_data);
            //             foreach ($value->checkbox as $day) {
            //                 $count = $day->count - $i;
            //                 if($count < 1){
            //                     $count = 7;
            //                 }
            //                 array_push(self::$new_schedule_data[$len - 1]->checkbox, ['count' => $count]);
            //             }
            //             unset($day);
            //         }
            //
            //         if($gap_break_from < 0 && $gap_break_to < 0){
            //             if(abs(fmod($gap_workday_from, 60))){
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod($gap_workday_from, 60));
            //             }else{
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (24 - intdiv(abs($gap_workday_from), 60)).':00';
            //             }
            //             self::$new_schedule_data[$len - 1]->workday[1]->value = '00:00';
            //             self::$new_schedule_data[$len - 1]->break[0]->value = intdiv(abs($gap_break_from), 60).':'.fmod($gap_break_from, 60);
            //             self::$new_schedule_data[$len - 1]->break[1]->value = intdiv(abs($gap_break_to), 60).':'.fmod($gap_break_to, 60);
            //             self::$new_schedule_data[$len - 2]->workday[0]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->workday[1]->value = intdiv(abs($gap_workday_to), 60).':'.fmod($gap_workday_to, 60);
            //             self::$new_schedule_data[$len - 2]->break[0]->value = intdiv(abs($gap_break_from), 60).':'.fmod($gap_break_from, 60);
            //             self::$new_schedule_data[$len - 2]->break[1]->value = intdiv(abs($gap_break_to), 60).':'.fmod($gap_break_to, 60);
            //
            //         }
            //         if($gap_break_from < 0 && $gap_break_to > 0 ){
            //             if(fmod($gap_workday_from, 60)){
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod($gap_workday_from, 60));
            //                 self::$new_schedule_data[$len - 1]->break[0]->value =(23 - intdiv(abs($gap_break_from), 60)).':'.(60 - fmod($gap_break_from, 60));
            //
            //             }else{
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (24 - intdiv(abs($gap_workday_from), 60)).':00';
            //                 self::$new_schedule_data[$len - 1]->break[0]->value =(24 - intdiv(abs($gap_break_from), 60)).':00';
            //
            //             }
            //             self::$new_schedule_data[$len - 1]->workday[1]->value = '00:00';
            //             self::$new_schedule_data[$len - 1]->break[1]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->workday[0]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->workday[1]->value = intdiv(abs($gap_workday_to), 60).':'.fmod($gap_workday_to, 60);
            //             self::$new_schedule_data[$len - 2]->break[0]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->break[1]->value = intdiv(abs($gap_break_to), 60).':'.fmod($gap_break_to, 60);
            //
            //
            //         }
            //         if($gap_break_to < 0 && $gap_break_to < 0){
            //             if(fmod($gap_workday_from, 60)){
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (23 - intdiv(abs($gap_workday_from), 60)).':'.(60 - fmod($gap_workday_from, 60));
            //                 self::$new_schedule_data[$len - 1]->break[0]->value =(23 - intdiv(abs($gap_break_from), 60)).':'.(60 - fmod($gap_break_from, 60));
            //                 self::$new_schedule_data[$len - 1]->break[1]->value = (23 - intdiv(abs($gap_break_to), 60)).':'.(60 - fmod($gap_break_to, 60));
            //
            //             }else{
            //                 self::$new_schedule_data[$len - 1]->workday[0]->value = (24 - intdiv(abs($gap_workday_from), 60)).':00';
            //                 self::$new_schedule_data[$len - 1]->break[0]->value =(24 - intdiv(abs($gap_break_from), 60)).':00';
            //                 self::$new_schedule_data[$len - 1]->break[1]->value = (24 - intdiv(abs($gap_break_to), 60)).':00';
            //
            //             }
            //             self::$new_schedule_data[$len - 1]->workday[1]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->workday[0]->value = '00:00';
            //             self::$new_schedule_data[$len - 2]->workday[1]->value = intdiv(abs($gap_workday_to), 60).':'.fmod($gap_workday_to, 60);
            //             self::$new_schedule_data[$len - 2]->break[0]->value = NULL;
            //             self::$new_schedule_data[$len - 2]->break[1]->value = NULL;
            //
            //         }
            //     }
            //
            // }


        }
        unset($value);

        return json_decode(json_encode(self::$new_schedule_data));


    }

    public static function convert_schedule_data($data, $utc_time){
        self::$utc_time = $utc_time;
        self::$stock_schedule_data = $data;
        $data = self::to_greenwich_utc($data);
        // dd($data);
        $data = self::search_and_set_missing_days($data);
        foreach ($data as $value) {
            foreach ($value->checkbox as $day) {
                $one_day_time_raw = [
                    'weekday' => $day->count,
                    'work_from' => $value->workday[0]->value,
                    'work_to' => $value->workday[1]->value,
                    'break_from' => $value->break[0]->value,
                    'break_to' => $value->break[1]->value,
                ];
                self::get_or_set_day_time_id($one_day_time_raw);
            }
            unset($day);
        }
        unset($value);
        // dd(self::$day_time_array);
        return self::$day_time_array;
    }

    public static function get_or_set_day_time_id($data){
        $raw_id = DB::table('schedule_day_time')->where(function($query) use ($data){
            return $query->where('weekday', $data['weekday'])
            ->where('work_from', $data['work_from'])
            ->where('work_to', $data['work_to'])
            ->where('break_from', $data['break_from'])
            ->where('break_to', $data['break_to']);
        })
        ->get('id')->toArray();
        if(count($raw_id)){
            array_push(self::$day_time_array, ['day_time_id' => $raw_id[0]->id, 'weekday' => $data['weekday']]);
        }else{
            $last_day_time_id = ScheduleDayTimeModel::insert_get_id($data);
            array_push(self::$day_time_array, ['day_time_id' => $last_day_time_id, 'weekday' => $data['weekday']]);
        }
    }


    public static function search_and_set_missing_days($data){
        $existing_days = [];
        foreach ($data as $value) {
            foreach ($value->checkbox as $day) {
                if(!in_array($day->count, $existing_days)){
                    array_push($existing_days, $day->count);
                }
            }
            unset($day);
        }
        unset($value);

        $missing_days = array_diff(self::$all_days, $existing_days);

        $value_is_null = [
            'workday' => [
                ['value' => NULL],
                ['value' => NULL],
            ],
            'break' => [
                ['value' => NULL],
                ['value' => NULL],
            ],
            'checkbox' => [],
        ];

        foreach ($missing_days as $value) {
            array_push($value_is_null['checkbox'], ['count' => $value]);
        }
        unset($value);
        $value_is_null = json_decode(json_encode($value_is_null));
        array_push($data, $value_is_null);
        return $data;
    }
















}
