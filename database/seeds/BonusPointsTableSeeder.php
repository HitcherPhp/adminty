<?php

use Illuminate\Database\Seeder;
use App\Models\BonusPointsModel;

class BonusPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $bonus_points = [];

        $clients = \App\Models\CustomerModel::all();

        foreach ($clients as $c) {
            $bonus_points[] = [
                'bonus_type_id' => 1,
                'points' => mt_rand(8000,10000),
                'customer_id' => $c->id,
                'parent_id' => null,
                'event' => 'added',
                'start' => DB::raw('NOW()')
            ];
        }

        DB::table('bonus_points')->insert($bonus_points);

        factory(BonusPointsModel::class, 1000)->create();
    }
}
