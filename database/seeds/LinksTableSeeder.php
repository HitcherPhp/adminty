<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'link' => 'factories',
                'name' => 'Фабрики',
                'icon' => 'mdi-home',
                'order_by' => 1
            ],
            [
                'link' => 'receptions',
                'name' => 'Приемные пункты',
                'icon' => 'mdi-navigation',
                'order_by' => 2
            ],
            [
                'link' => 'staff',
                'name' => 'Сотрудники',
                'icon' => 'mdi-account-multiple',
                'order_by' => 3
            ],
            [
                'link' => 'customers',
                'name' => 'Клиенты',
                'icon' => 'mdi-account-group',
                'order_by' => 4
            ],
            [
                'link' => 'orders',
                'name' => 'Заказы',
                'icon' => 'mdi-order-bool-ascending-variant',
                'order_by' => 5
            ],
            [
                'link' => 'promo_codes',
                'name' => 'Промо-акции',
                'icon' => 'mdi-credit-card',
                'order_by' => 6
            ],
            [
                'link' => 'franchises',
                'name' => 'Организации',
                'icon' => 'mdi-account-supervisor-circle',
                'order_by' => 7
            ]
        ];
        DB::table('links')->insert($links);
    }
}
