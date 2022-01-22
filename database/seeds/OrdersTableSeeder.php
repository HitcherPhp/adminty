<?php

use Illuminate\Database\Seeder;
use App\Models\OrderModel;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OrderModel::class, 70)->create();
    }
}
