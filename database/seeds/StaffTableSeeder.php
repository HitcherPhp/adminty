<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       DB::table('staff')->insert([
           [
               'id' => '1',
               'name' => 'Яковлев Игорь Владимирович',
               'phone' => '89083073304',
               'email' => 'zrjdktd.igor.0820@gmail.com',
               'email_verified_at' => NUll,
               'password' => '$2y$10$.LYsyG0gzBrYGHXLEecHYuBv3wy8W3PPHIo74zVLozBm7xJmsViCm',
               'remember_token' => '9KfAnrPy9oPPGoCd764YwHzIxyEgzsDRY0QbBY6B5gXx0MKw9SZDwI9JLppP',
               'created_at' => '2020-10-22 12:28:14',
               'updated_at' => '2020-10-22 12:28:14',
               'group_id' => '3'
           ],
           [
               'id' => '2',
               'name' => 'Васильев Павел Олегович',
               'phone' => '89134264862',
               'email' => 'pasha2011vas@mail.ru',
               'email_verified_at' => NUll,
               'password' => '$2y$10$yRgCGl1gnOu2nWlGBRrohuaxYYJB80j20X55w4ZHaff6y8jaF6ttq',
               'remember_token' => '9KfAnrPy9oPPGoCd764YwHzIxyEgzsDRY0QbBY6B5gXx0MKw9SZDwI9JLppP',
               'created_at' => '2020-10-22 12:28:14',
               'updated_at' => '2020-10-22 12:28:14',
               'group_id' => '2'
           ],
           [
               'id' => '3',
               'name' => 'Артем',
               'phone' => '89003327027',
               'email' => 'drtoxit@gmail.com',
               'email_verified_at' => NUll,
               'password' => '$2y$10$VSr3NigC0o0ieuvBNP6lkOGCAuqbCNBa/9Q7QhvG8cOOxdk7T5D1i',
               'remember_token' => '9KfAnrPy9oPPGoCd764YwHzIxyEgzsDRY0QbBY6B5gXx0MKw9SZDwI9JLppP',
               'created_at' => '2020-10-22 12:28:14',
               'updated_at' => '2020-10-22 12:28:14',
               'group_id' => '1'
           ],
           [
               'id' => '4',
               'name' => 'Константин',
               'phone' => '89003457027',
               'email' => 'stepanovkpru@gmail.com',
               'email_verified_at' => NUll,
               'password' => '$2y$10$VSr3NigC0o0ieuvBNP6lkOGCAuqbCNBa/9Q7QhvG8cOOxdk7T5D1i',
               'remember_token' => '9KfAnrPy9oPPGoCd764YwHzIxyEgzsDRY0QbBY6B5gXx0MKw9SZDwI9JLppP',
               'created_at' => '2020-10-22 12:28:14',
               'updated_at' => '2020-10-22 12:28:14',
               'group_id' => '1'
           ],
           [
               'id' => '5',
               'name' => 'Дмитрий',
               'phone' => '89003457027',
               'email' => 'adel.ernandies@mail.ru',
               'email_verified_at' => NUll,
               'password' => '$2y$10$VSr3NigC0o0ieuvBNP6lkOGCAuqbCNBa/9Q7QhvG8cOOxdk7T5D1i',
               'remember_token' => '9KfAnrPy9oPPGoCd764YwHzIxyEgzsDRY0QbBY6B5gXx0MKw9SZDwI9JLppP',
               'created_at' => '2020-10-22 12:28:14',
               'updated_at' => '2020-10-22 12:28:14',
               'group_id' => '1'
           ],
       ]);
       factory(App\Models\StaffModel::class, 120)->create();
     }
}
