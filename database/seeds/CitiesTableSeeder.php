<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cities = [
            [
                'id' => '1',
                'name' => 'Самара',
                'alias' => 'Samara',
                'timezone_id' => 2,
                'country_id' => 1,
                'factory_id' => 1
            ],
            [
                'id' => '2',
                'name' => 'Ангарск',
                'alias' => 'Angarsk',
                'timezone_id' => 5,
                'country_id' => 1,
                'factory_id' => 2
            ],
            [
                'id' => '3',
                'name' => 'Тольятти',
                'alias' => 'Tolyatti',
                'timezone_id' => 2,
                'country_id' => 1,
                'factory_id' => 3
            ],
            [
                'id' => '4',
                'name' => 'Находка',
                'alias' => 'Nakhodka',
                'timezone_id' => 6,
                'country_id' => 1,
                'factory_id' => 4
            ],
            [
                'id' => '5',
                'name' => 'Омск',
                'alias' => 'Omsk',
                'timezone_id' => 3,
                'country_id' => 1,
                'factory_id' => 5
            ],
            [
                'id' => '6',
                'name' => 'Тара',
                'alias' => 'Tara',
                'timezone_id' => 3,
                'country_id' => 1,
                'factory_id' => 6
            ],
            [
                'id' => '7',
                'name' => 'Москва',
                'alias' => 'Moscow',
                'timezone_id' => 1,
                'country_id' => 1,
                'factory_id' => 7
            ],
            [
                'id' => '8',
                'name' => 'Новосибирск',
                'alias' => 'Novosibirsk',
                'timezone_id' => 4,
                'country_id' => 1,
                'factory_id' => 8
            ],
            [
                'id' => '9',
                'name' => 'Сызрань',
                'alias' => 'Sizran',
                'timezone_id' => 2,
                'country_id' => 1,
                'factory_id' => 9
            ],
            [
                'id' => '10',
                'name' => 'Иркутск',
                'alias' => 'Irkutsk',
                'timezone_id' => 5,
                'country_id' => 1,
                'factory_id' => 10
            ],
            [
                'id' => '11',
                'name' => 'Братск',
                'alias' => 'Bratsk',
                'timezone_id' => 5,
                'country_id' => 1,
                'factory_id' => 11
            ],
            [
                'id' => '12',
                'name' => 'Владивосток',
                'alias' => 'Vladivostok',
                'timezone_id' => 6,
                'country_id' => 1,
                'factory_id' => 12
            ],
        ];
        DB::table('cities')->insert($cities);
    }
}
