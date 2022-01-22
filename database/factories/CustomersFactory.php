<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerModel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(CustomerModel::class, function (Faker $faker) {
    $user = [
        'name' => $faker->name,
        'phone' => mt_rand(89005623200,89999999999),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'type_of_ownership_id' => mt_rand(1, 4),
        'deleted' => mt_rand(0,1)
    ];
    return $user;
});
