<?php

use Illuminate\Database\Seeder;

class ScheduleFactoryReceptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schedule_factory_reception = [
          [
            'schedule_id' => '1',
            'factory_id' => '6',
            'reception_id' => NULL
          ],
          [
            'schedule_id' => '2',
            'factory_id' => NULL,
            'reception_id' => '1'
          ]
        ];
        DB::table('schedule_factory_reception')->insert($schedule_factory_reception);
    }
}
