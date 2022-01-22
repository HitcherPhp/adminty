<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class  OrganisationsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organisations = [
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME',
                'fr_value' => 'ООО "Гонец"'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'FULL_NAME_ORGANIZATION',
                'fr_value' => 'Общество с ограниченной ответственностью «Гонeц»'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_PROPERTY_FORM',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'POSITION_HEAD',
                'fr_value' => 'Генеральный директор'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_HEAD',
                'fr_value' => 'Степанов Константин Петрович'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME_FOR_DOC',
                'fr_value' => 'Степанова Константина Петровича'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BANK',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BIC',
                'fr_value' => '44525700'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_CA',
                'fr_value' => '30101810200000000000'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_PA',
                'fr_value' => '40702810000000000000'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INN',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_COORDS',
                'fr_value' => '55.763375,37.586198'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_KPP',
                'fr_value' => '770301001'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'BASIS_WHICH_PARTY_ACTING',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_ACCOUNTANT',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INDEX',
                'fr_value' => '123242'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ADDRESS',
                'fr_value' => '123242, г. Москва, ул. Садовая-Кудринская, д. 11, строение 1, офис 238'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'PHONE_NUMBER_INTERVIEW',
                'fr_value' => '79267359103'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ONLY_ADDRESS',
                'fr_value' => 'ул. Садовая-Кудринская, д. 11'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'SITE_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'COURIER_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'COURIER_PHONE',
                'fr_value' => '+7 (499) 113 32-90'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_PHONE',
                'fr_value' => '+7 (499) 112 35-57'
            ],
            [
                'franchise_id' => '1',
                'customer_id' => NULL,
                'fr_key' => 'OPERATOR_PHONE',
                'fr_value' => '+7 (499) 112 35-57'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME',
                'fr_value' => 'ООО "Leda"'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'FULL_NAME_ORGANIZATION',
                'fr_value' => 'Общество с ограниченной ответственностью «Leda»'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_PROPERTY_FORM',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'POSITION_HEAD',
                'fr_value' => 'Главный главнюк'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_HEAD',
                'fr_value' => 'Антонов Николай Юрьевич'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME_FOR_DOC',
                'fr_value' => 'Антонова Николая Юрьевича'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BANK',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BIC',
                'fr_value' => '75684300'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_CA',
                'fr_value' => '30134560200000000000'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_PA',
                'fr_value' => '40983510000000000000'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INN',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_COORDS',
                'fr_value' => '58.7236575,34.5355198'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_KPP',
                'fr_value' => '779231001'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'BASIS_WHICH_PARTY_ACTING',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_ACCOUNTANT',
                'fr_value' => 'Мефодьева Антонина Юрьевна'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INDEX',
                'fr_value' => '195742'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ADDRESS',
                'fr_value' => '195742, г. НЕ Москва, ул. НЕ Садовая-Кудринская, д. НЕ 11, строение НЕ 1, офис НЕ 238'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'PHONE_NUMBER_INTERVIEW',
                'fr_value' => '79275483856'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ONLY_ADDRESS',
                'fr_value' => 'ул.НЕ Садовая-Кудринская, д. 11'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'SITE_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'COURIER_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_EMAIL',
                'fr_value' => ''
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'COURIER_PHONE',
                'fr_value' => '+7 (499) 743 32-45'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_PHONE',
                'fr_value' => '+7 (499) 836 64-83'
            ],
            [
                'franchise_id' => '2',
                'customer_id' => NULL,
                'fr_key' => 'OPERATOR_PHONE',
                'fr_value' => '+7 (499) 836 64-83'
            ]

        ];
        DB::table('organisations_attributes')->insert($organisations);
    }
}
