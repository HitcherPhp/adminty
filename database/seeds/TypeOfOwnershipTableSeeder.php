<?php

use Illuminate\Database\Seeder;

class TypeOfOwnershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_of_ownerships = [
            [
                'id' => 1,
                'name' => 'Физ. лицо'
            ],
            [
                'id' => 2,
                'name' => 'ОАО'
            ],
            [
                'id' => 3,
                'name' => 'ООО'
            ],
            [
                'id' => 4,
                'name' => 'ИП'
            ]
        ];
        DB::table('type_of_ownerships')->insert($type_of_ownerships);
    }
}
