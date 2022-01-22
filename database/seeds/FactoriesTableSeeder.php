<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class FactoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\FactoryModel::class, 67)->create();
    }
}
