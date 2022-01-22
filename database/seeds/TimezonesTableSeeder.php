<?php

use Illuminate\Database\Seeder;

class TimezonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timezone = [
            [
                'utc' => '+03:00',
                'timezone' => 'MSK'
            ],
            [
                'utc' => '+04:00',
                'timezone' => 'SAMT'
            ],
            [
                'utc' => '+06:00',
                'timezone' => 'OMST'
            ],
            [
                'utc' => '+07:00',
                'timezone' => 'NOVT'
            ],
            [
                'utc' => '+08:00',
                'timezone' => 'IRKT'
            ],
            [
                'utc' => '+10:00',
                'timezone' => 'VLAT'
            ],
        ];
        DB::table('timezones')->insert($timezone);
    }
}
