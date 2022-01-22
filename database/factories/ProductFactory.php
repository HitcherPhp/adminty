<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductModel;
use Faker\Generator as Faker;

$factory->define(ProductModel::class, function (Faker $faker) {

    $st = [1, 2, 3, 4];
    $name_ar = [
        'Ветровка',
        'Кардиган',
        'Пончо',
        'Палантин',
        'Пиджак летний с коротким рукавом',
        'Кардиган из пальтовой ткани',
        'Китель',
        'Пиджак из пальтовой ткани',
        'Жилет из пальтовой ткани',
        'Жакет на подкладе',
        'Кардиган на подкладе',
        'Пальто летнее',
        'Плащ',
        'Галстук',
        'Брюки',
        'Пиджак',
        'Смокинг',
        'Фрак',
        'Френч',
        'Жилет',
        'Рубашка',
        'Блузка',
    ];

    static $st_cntr = 0; // 3 max
    static $nm_cntr = 0; // 21 max

    $s_t_i = $st[$st_cntr];
    $name = $name_ar[$nm_cntr];

    $nm_cntr++;

    if ($nm_cntr > 21){
        $st_cntr++;
        $nm_cntr = 0;
    }



    return [
        'service_type_id' => $s_t_i,
        'name' => $name,
        'period' => '3-4 дня',
        'image_id' => 1,
        'is_vip' => 1,
        'description' => 'text'
    ];



});
