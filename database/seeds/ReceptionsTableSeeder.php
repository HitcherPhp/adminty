<?php

use Illuminate\Database\Seeder;

class ReceptionsTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        factory(App\Models\ReceptionModel::class, 85)->create();
    }
}
