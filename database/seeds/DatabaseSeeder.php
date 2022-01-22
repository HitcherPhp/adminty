<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusesTableSeeder::class);
        $this->call(PaymentMethodsSeeder::class);

        $this->call(GroupsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(GroupsPermissionsTableSeeder::class);
        $this->call(TypeOfOwnershipTableSeeder::class);
        $this->call(StaffTableSeeder::class);


        $this->call(TimezonesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AddressesTableSeeder::class);

        $this->call(FactoriesTableSeeder::class);
        $this->call(ReceptionsTableSeeder::class);

        $this->call(ScheduleDayTimeTableSeeder::class);
        $this->call(ScheduleFactoryReceptionTableSeeder::class);
        $this->call(ScheduleCompilationSeeder::class);

        $this->call(CustomersTableSeeder::class);



        $this->call(FranchisesTableSeeder::class);
        $this->call(OrganisationsKeyDescriptionTableSeeder::class);
        $this->call(OrganisationsAttributesTableSeeder::class);


        $this->call(BonusTypesTableSeeder::class);
        $this->call(BonusPointsTableSeeder::class);

        $this->call(PromoCodesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(StatusesGroupsTableSeeder::class);

        $this->call(LinksTableSeeder::class);

        $this->call(CityFranchiseFactoryReceptionUserTableSeeder::class);
        $this->call(ImagesTableSeeder::class);

        $this->call(CategoriesTableSeeder::class);
        $this->call(ServiceTypeTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CityCategoryProductTableSeeder::class);
        $this->call(OrderProductsSeeder::class);

        $this->call(PromotionsTableSeeder::class);
        $this->call(DiscountsTableSeeder::class);


    }
}
