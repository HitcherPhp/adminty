<?php

use Illuminate\Database\Seeder;
use App\Models\StaffModel;
use App\Models\FranchiseAttributeModel;

class CityFranchiseFactoryReceptionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $franchise = [
            [
                'city_id' => 7,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 1
            ],
            [
                'city_id' => 5,
                'franchise_id' => 2,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 2
            ],
            [
                'city_id' => 3,
                'franchise_id' => 5,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 3
            ],
            [
                'city_id' => 7,
                'franchise_id' => 4,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 1
            ],
            [
                'city_id' => 7,
                'franchise_id' => 3,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 1
            ],
            [
                'city_id' => 5,
                'franchise_id' => 6,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 2
            ],
            [
                'city_id' => 5,
                'franchise_id' => 8,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 2
            ],
            [
                'city_id' => 3,
                'franchise_id' => 9,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 3
            ],
            [
                'city_id' => 7,
                'franchise_id' => 2,
                'factory_id' => 1,
                'reception_id' => null,
                'user_id' => null
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => null
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => 2,
                'reception_id' => null,
                'user_id' => null
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => 4,
                'user_id' => null
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => 5,
                'user_id' => null
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 4
            ],
            [
                'city_id' => 1,
                'franchise_id' => 3,
                'factory_id' => null,
                'reception_id' => null,
                'user_id' => 4
            ],
            [
                'city_id' => 1,
                'franchise_id' => 1,
                'factory_id' => null,
                'reception_id' => 6,
                'user_id' => null
            ],


        ];

        DB::table('city_franchise_factory_reception_user')->insert($franchise);
        factory(App\Models\CityFranchiseFactoryReceptionUserModel::class, 500)->create();

    }
}
