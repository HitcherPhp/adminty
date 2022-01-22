<?php

use Illuminate\Database\Seeder;

class BonusTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonus_types = [
            [
                'id' => '1',
                'name' => 'bonus',
                'accrual_percent' => '3',
                'payment_percent' => '30',
                'lifetime' => '2592000'
            ],
            [
                'id' => '2',
                'name' => 'partner',
                'accrual_percent' => '10',
                'payment_percent' => '100',
                'lifetime' => '31536000'
            ]
        ];
        DB::table('bonus_types')->insert($bonus_types);
    }
}
