<?php

use Illuminate\Database\Seeder;

class ScheduleCompilationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule_compilation = [
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '1'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '3'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '5'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '7'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '9'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '11'
                ],
                [
                    'schedule_id' => '1',
                    'schedule_day_time_id' => '12'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '2'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '4'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '6'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '8'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '10'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '11'
                ],
                [
                    'schedule_id' => '2',
                    'schedule_day_time_id' => '12'
                ],

        ];

        DB::table('schedule_compilation')->insert($schedule_compilation);

    }
}
