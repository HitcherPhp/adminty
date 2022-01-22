<?php

use Illuminate\Database\Seeder;

class OrganisationsKeyDescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organisations_key_description = [
            [
                'fr_key' => 'REQUISITE_ORG_NAME',
                'description' => 'Наименование организации',
                'order_by' => 1
            ],
            [
                'fr_key' => 'FULL_NAME_ORGANIZATION',
                'description' => 'Полное наименование организации',
                'order_by' => 2
            ],
            [
                'fr_key' => 'SHORT_NAME_PROPERTY_FORM',
                'description' => 'Краткое наименование формы собственности (Пример: ИП)',
                'order_by' => 3
            ],
            [
                'fr_key' => 'POSITION_HEAD',
                'description' => 'Должность руководителя',
                'order_by' => 4
            ],
            [
                'fr_key' => 'SHORT_NAME_HEAD',
                'description' => 'Имя и инициалы руководителя',
                'order_by' => 5
            ],
            [
                'fr_key' => 'REQUISITE_ORG_NAME_FOR_DOC',
                'description' => 'ФИО руководителя в родительном падеже',
                'order_by' => 6
            ],
            [
                'fr_key' => 'REQUISITE_ORG_BANK',
                'description' => 'Наименование банка франчайзи',
                'order_by' => 7
            ],
            [
                'fr_key' => 'REQUISITE_ORG_BIC',
                'description' => 'БИК франчайзи',
                'order_by' => 8
            ],
            [
                'fr_key' => 'REQUISITE_ORG_CA',
                'description' => 'Корр счет франчайзи',
                'order_by' => 9
            ],
            [
                'fr_key' => 'REQUISITE_ORG_PA',
                'description' => 'Расчетный счет франчайзи',
                'order_by' => 10
            ],
            [
                'fr_key' => 'REQUISITE_ORG_INN',
                'description' => 'ИНН франчайзи',
                'order_by' => 11
            ],
            [
                'fr_key' => 'REQUISITE_ORG_COORDS',
                'description' => 'Координаты адреса офиса',
                'order_by' => 12
            ],
            [
                'fr_key' => 'REQUISITE_ORG_KPP',
                'description' => 'КПП франчайзи',
                'order_by' => 13
            ],
            [
                'fr_key' => 'BASIS_WHICH_PARTY_ACTING',
                'description' => 'На основании чего действует сторона (Устава)',
                'order_by' => 14
            ],
            [
                'fr_key' => 'SHORT_NAME_ACCOUNTANT',
                'description' => 'Имя и инициалы бухгалтера',
                'order_by' => 15
            ],
            [
                'fr_key' => 'REQUISITE_ORG_INDEX',
                'description' => 'Индекс офиса франчайзи',
                'order_by' => 16
            ],
            [
                'fr_key' => 'REQUISITE_ORG_ADDRESS',
                'description' => 'Контактный адрес',
                'order_by' => 17
            ],
            [
                'fr_key' => 'PHONE_NUMBER_INTERVIEW',
                'description' => 'Номер для звонка после заполнения данных',
                'order_by' => 18
            ],
            [
                'key' => 'REQUISITE_ORG_ONLY_ADDRESS',
                'description' => 'Только адрес франчайзи (улица и дом)',
                'order_by' => 19
            ],
            [
                'key' => 'SITE_EMAIL',
                'description' => 'Почта франчайзи',
                'order_by' => 20
            ],
            [
                'fr_key' => 'COURIER_EMAIL',
                'description' => 'Почта для приема курьеров',
                'order_by' => 21
            ],
            [
                'fr_key' => 'MANAGERS_EMAIL',
                'description' => 'Почта для менеджеров',
                'order_by' => 22
            ],
            [
                'fr_key' => 'COURIER_PHONE',
                'description' => 'Телефон для приема курьеров',
                'order_by' => 23
            ],
            [
                'fr_key' => 'MANAGERS_PHONE',
                'description' => 'Телефон менеджеров',
                'order_by' => 24
            ],
            [
                'fr_key' => 'OPERATOR_PHONE',
                'description' => 'Телефон операторов',
                'order_by' => 25
            ]

        ];

        DB::table('organisations_key_description')->insert($organisations_key_description);
    }
}
