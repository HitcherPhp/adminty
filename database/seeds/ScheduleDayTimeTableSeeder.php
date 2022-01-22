<?php

use Illuminate\Database\Seeder;

class ScheduleDayTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule_day_time = [
            [
                'id' => '1',
                'weekday' => '1',
                'work_from' => '09:00',
                'work_to' => '18:00',
                'break_from' => '12:00',
                'break_to' => '13:00',
            ],
            [
                'id' => '2',
                'weekday' => '1',
                'work_from' => '10:00',
                'work_to' => '19:00',
                'break_from' => '12:30',
                'break_to' => '13:30',
            ],
            [
                'id' => '3',
                'weekday' => '2',
                'work_from' => '09:00',
                'work_to' => '18:00',
                'break_from' => '12:00',
                'break_to' => '13:00',
            ],
            [
                'id' => '4',
                'weekday' => '2',
                'work_from' => '10:00',
                'work_to' => '19:00',
                'break_from' => '12:30',
                'break_to' => '13:30',
            ],
            [
                'id' => '5',
                'weekday' => '3',
                'work_from' => '09:00',
                'work_to' => '18:00',
                'break_from' => '12:00',
                'break_to' => '13:00',
            ],
            [
                'id' => '6',
                'weekday' => '3',
                'work_from' => '10:00',
                'work_to' => '19:00',
                'break_from' => '12:30',
                'break_to' => '13:30',
            ],
            [
                'id' => '7',
                'weekday' => '4',
                'work_from' => '09:00',
                'work_to' => '18:00',
                'break_from' => '12:00',
                'break_to' => '13:00',
            ],
            [
                'id' => '8',
                'weekday' => '4',
                'work_from' => '10:00',
                'work_to' => '19:00',
                'break_from' => '12:30',
                'break_to' => '13:30',
            ],
            [
                'id' => '9',
                'weekday' => '5',
                'work_from' => '09:00',
                'work_to' => '18:00',
                'break_from' => '12:00',
                'break_to' => '13:00',
            ],
            [
                'id' => '10',
                'weekday' => '5',
                'work_from' => '10:00',
                'work_to' => '19:00',
                'break_from' => '12:30',
                'break_to' => '13:30',
            ],
            [
                'id' => '11',
                'weekday' => '6',
                'work_from' => NULL,
                'work_to' => NULL,
                'break_from' => NULL,
                'break_to' => NULL,
            ],
            [
                'id' => '12',
                'weekday' => '7',
                'work_from' => NULL,
                'work_to' => NULL,
                'break_from' => NULL,
                'break_to' => NULL,
            ],

        ];
        DB::table('schedule_day_time')->insert($schedule_day_time);
    }
}
