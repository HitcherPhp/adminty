<?php

use Illuminate\Database\Seeder;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `promotions` (`id`, `perpetual`, `type`, `description`) VALUES (1, true, 'FREE_SHIPPING', 'Эта акция действует на все товары франшизы по умолчанию'), (2, false, 'WEEK_PRODUCT', 'Скидка на товары')");
    }
}
