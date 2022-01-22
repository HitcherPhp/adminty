<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'name' => 'dfoak322kfpokfr.jpg',
            'path' => 'img/products/middleSize/'
        ]);
    }
}
