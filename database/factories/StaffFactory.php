<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StaffModel;
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

$factory->define(StaffModel::class, function (Faker $faker) {
    $user = [
        'name' => $faker->name,
        'phone' => mt_rand(),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token' => Str::random(10),
        'group_id' => mt_rand(1, 8),
    ];
    return $user;
});
