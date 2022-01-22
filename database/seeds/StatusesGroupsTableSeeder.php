<?php

use Illuminate\Database\Seeder;

class StatusesGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\StatusesGroupsModel::class, 70)->create();
    }
}
