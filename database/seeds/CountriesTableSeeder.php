<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $countries = [
            [
                'id' => 1,
                'name' => 'Россия',
                'alias' => 'RUS',
                'currency_code' => 'RUB',
                'currency_number' => '643',
                'currency_symbol' => '₽',
                'phone_geocode' => '+7',
                'phone_mask' => '(###) ###-##-##'
            ],
        ];
        DB::table('countries')->insert($countries);
    }
}
