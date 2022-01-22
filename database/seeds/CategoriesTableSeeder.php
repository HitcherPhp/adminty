<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $categories = \App\Facades\Catalog::CATEGORIES;

        foreach ($categories as $c) {
            DB::table('categories')->insert((array)$c);
        }

        $categories = DB::table('categories')->select('id')->get()->toArray();
        foreach ($categories as $c) {
            DB::update("UPDATE categories c JOIN categories pc ON c.parent_id = pc.id SET c.parent_ids = CONCAT(pc.parent_ids, ',', c.parent_id) where c.id = ?", [$c->id]);
        }
    }
}
