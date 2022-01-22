<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FranchisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $franchises = [
            [
                'id' => 1,
                'name' => 'ООО "Гонец"',
                'creator_id' => 2
            ],
            [
                'id' => 2,
                'name' => 'ООО "Leda"',
                'creator_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'ООО "FAS"',
                'creator_id' => 1
            ],
            [
                'id' => 4,
                'name' => 'ООО "MMM"',
                'creator_id' => 2
            ],
            [
                'id' => 5,
                'name' => 'ООО "NASA"',
                'creator_id' => 1
            ],
            [
                'id' => 6,
                'name' => 'ООО "Ж"',
                'creator_id' => 1
            ],
            [
                'id' => 7,
                'name' => 'ООО "Чод"',
                'creator_id' => 1
            ],
            [
                'id' => 8,
                'name' => 'ООО "Пост"',
                'creator_id' => 1
            ],
            [
                'id' => 9,
                'name' => 'ООО "Кот"',
                'creator_id' => 2
            ],
            [
                'id' => 10,
                'name' => 'ООО "АААА"',
                'creator_id' => 1
            ],
            [
                'id' => 11,
                'name' => 'ООО "МАВ"',
                'creator_id' => 1
            ],
            [
                'id' => 12,
                'name' => 'ООО "ХНК"',
                'creator_id' => 1
            ],
        ];
        DB::table('franchises')->insert($franchises);
    }
}
