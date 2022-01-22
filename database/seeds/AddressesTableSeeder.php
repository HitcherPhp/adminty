<?php

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = [
            [
                'id' => 1,
                'city_id' => 1,
                'address' => 'ул. Петрова, д. 48 к.4',
                'flat/office' => 87,
                'name' => 'ТЦ "Mrl"',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.74140690086479',
                'longitude' => '37.69247416455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 2,
                'city_id' => 2,
                'address' => 'ул. Майская, д. 48 к.4',
                'flat/office' => null,
                'name' => 'Метро Пушкинская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 3,
                'city_id' => 3,
                'address' => 'ул. Ильюшина, д. 68',
                'flat/office' => null,
                'name' => 'м. Савеловская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 4,
                'city_id' => 4,
                'address' => 'ул. Афанасьева, д.19',
                'flat/office' => 34,
                'name' => 'ТЦ "Дом Мод"',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 5,
                'city_id' => 5,
                'address' => 'Московский проспект , д.32',
                'flat/office' => null,
                'name' => 'ТЦ "Новый мир"',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 6,
                'city_id' => 6,
                'address' => 'Ленинградское шоссе, д.5/3',
                'flat/office' => null,
                'name' => 'м. Таганская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 7,
                'city_id' => 7,
                'address' => 'Ул. Урукова, д.82/2',
                'flat/office' => 98,
                'name' => 'метро академическая',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 8,
                'city_id' => 8,
                'address' => 'Шоссе энтузиастов, д.21 к.4',
                'flat/office' => null,
                'name' => 'ТЦ "Океания"',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 9,
                'city_id' => 9,
                'address' => 'ул. Партизанская, д.44',
                'flat/office' => null,
                'name' => 'Метро Кузнецкий мост',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 10,
                'city_id' => 10,
                'address' => 'Соломенский проспект, д.105',
                'flat/office' => 105,
                'name' => 'м. Щукинская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 11,
                'city_id' => 11,
                'address' => 'ул.Академика бочвара, д.8',
                'flat/office' => 39,
                'name' => 'м. Щукинская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
            [
                'id' => 12,
                'city_id' => 12,
                'address' => 'ул. Комсомольская, д.1',
                'flat/office' => 105,
                'name' => 'м. Кунцевская',
                'comment' => 'Описание, как добраться до приемки',
                'latitude' => '55.7414230690086479',
                'longitude' => '37.6924742316455079',
                'courier' => 'Типичное курьерское имя',
                'date_time_from' => '2020-10-22 12:28:14',
                'date_time_to' => '2020-10-23 14:28:14',
            ],
        ];

        DB::table('addresses')->insert($addresses);
    }
}