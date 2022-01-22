<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $groups = [
            [
                'id' => '1',
                'name' => 'Основатель'
            ],
            [
                'id' => '2',
                'name' => 'Администратор франшизы - завода'
            ],
            [
                'id' => '3',
                'name' => 'Администратор франшизы - приемного пункта'
            ],
            [
                'id' => '4',
                'name' => 'Оператор'
            ],
            [
                'id' => '5',
                'name' => 'Менеджер по развитию'
            ],
            [
                'id' => '6',
                'name' => 'Менеджер по продажам'
            ],
            [
                'id' => '7',
                'name' => 'Менеджер по приемщицам'
            ],
            [
                'id' => '8',
                'name' => 'Приемщик'
            ]
        ];
        DB::table('groups')->insert($groups);
    }
}
