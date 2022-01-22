<?php

use Illuminate\Database\Seeder;
use App\Models\PromoCodeModel;

class PromoCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PromoCodeModel::class, 20)->create();
    }
}
