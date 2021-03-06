<?php


namespace App\Facades;

class Catalog
{
    const PRODUCTS = [
        [
            'id' => 1,
            'name' => 'Ветровка',
        ],
        [
            'id' => 2,
            'name' => 'Кардиган',
        ],
        [
            'id' => 3,
            'name' => 'Пончо',
        ],
        [
            'id' => 4,
            'name' => 'Палантин',
        ],
        [
            'id' => 5,
            'name' => 'Пиджак летний с коротким рукавом',
        ],
        [
            'id' => 6,
            'name' => 'Кардиган из пальтовой ткани',
        ],
        [
            'id' => 7,
            'name' => 'Китель',
        ],
        [
            'id' => 8,
            'name' =>  'Пиджак из пальтовой ткани',
        ],
        [
            'id' => 9,
            'name' =>  'Жилет из пальтовой ткани',
        ],
        [
            'id' => 10,
            'name' =>  'Жакет на подкладе',
        ],
        [
            'id' => 11,
            'name' =>  'Кардиган на подкладе',
        ],
        [
            'id' => 12,
            'name' =>  'Пальто летнее',
        ],
        [
            'id' => 13,
            'name' =>  'Плащ',
        ],
        [
            'id' => 14,
            'name' =>  'Галстук',
        ],
        [
            'id' => 15,
            'name' =>  'Брюки',
        ],
        [
            'id' => 16,
            'name' =>  'Пиджак',
        ],
        [
            'id' => 17,
            'name' =>  'Смокинг',
        ],
        [
            'id' => 18,
            'name' =>  'Фрак',
        ],
        [
            'id' => 19,
            'name' => 'Френч',
        ],
        [
            'id' => 20,
            'name' => 'Жилет',
        ],
        [
            'id' => 21,
            'name' => 'Рубашка',
        ],
        [
            'id' => 22,
            'name' => 'Блузка',
        ]
    ];


    const CATEGORIES = [
        [
            'id' => 1,
            'name' => 'Химчистка',
            'parent_id' => NULL,
            'order_by' => 1,
            'alias' => 'himchistka',
        ],
        [
            'id' => 2,
            'name' => 'Крашение',
            'parent_id' => NULL,
            'order_by' => 2,
            'alias' => 'krashenie',
        ],
        [
            'id' => 3,
            'name' => 'Хранение',
            'parent_id' => NULL,
            'order_by' => 3,
            'alias' => 'hranenie',
        ],
        [
            'id' => 4,
            'name' => 'Ремонт',
            'parent_id' => NULL,
            'order_by' => 4,
            'alias' => 'remont',
        ],
        [
            'id' => 5,
            'name' => 'Текстиль и трикотаж ',
            'parent_id' => 1,
            'order_by' => 1,
            'alias' => 'tekstil-i-trikotazh',
        ],
        [
            'id' => 6,
            'name' => 'Верхняя одежда',
            'parent_id' => 5,
            'order_by' => 1,
            'alias' => 'verhnjaja-odezhda',
        ],
        [
            'id' => 7,
            'name' => 'Деловой костюм',
            'parent_id' => 5,
            'order_by' => 2,
            'alias' => 'delovoj-kostjum',
        ],
        [
            'id' => 8,
            'name' => 'Джинса',
            'parent_id' => 5,
            'order_by' => 3,
            'alias' => 'dzhinsa',
        ],
        [
            'id' => 9,
            'name' => 'Платья и юбки',
            'parent_id' => 5,
            'order_by' => 4,
            'alias' => 'platja-i-jubki',
        ],
        [
            'id' => 10,
            'name' => 'Повседневная одежда',
            'parent_id' => 5,
            'order_by' => 5,
            'alias' => 'povsednevnaja-odezhda',
        ],
        [
            'id' => 11,
            'name' => 'Аксессуары',
            'parent_id' => 5,
            'order_by' => 6,
            'alias' => 'aksessuary',
        ],
        [
            'id' => 12,
            'name' => 'Ручное удаление пилинга',
            'parent_id' => 5,
            'order_by' => 7,
            'alias' => 'ruchnoe-udalenie-pilinga',
        ],
        [
            'id' => 13,
            'name' => 'Теплая одежда, зимний спорт ',
            'parent_id' => 1,
            'order_by' => 2,
            'alias' => 'teplaja-odezhda-zimnij-sport',
        ],
        [
            'id' => 14,
            'name' => 'Комбинезоны, брюки',
            'parent_id' => 13,
            'order_by' => 1,
            'alias' => 'kombinezony-brjuki',
        ],
        [
            'id' => 15,
            'name' => 'Куртки, пуховики',
            'parent_id' => 13,
            'order_by' => 2,
            'alias' => 'kurtki-puhoviki',
        ],
        [
            'id' => 16,
            'name' => 'Пальто, плащи',
            'parent_id' => 13,
            'order_by' => 3,
            'alias' => 'palto-plaschi',
        ],
        [
            'id' => 17,
            'name' => 'Хоккейная форма',
            'parent_id' => 13,
            'order_by' => 4,
            'alias' => 'hokkejnaja-forma',
        ],
        [
            'id' => 18,
            'name' => 'Кожа и дубленки ',
            'parent_id' => 1,
            'order_by' => 3,
            'alias' => 'kozha-i-dublenki',
        ],
        [
            'id' => 19,
            'name' => 'Дубленки',
            'parent_id' => 18,
            'order_by' => 1,
            'alias' => 'dublenki',
        ],
        [
            'id' => 20,
            'name' => 'Куртки из кожи и замши',
            'parent_id' => 18,
            'order_by' => 2,
            'alias' => 'kurtki-iz-kozhi-i-zamshi',
        ],
        [
            'id' => 21,
            'name' => 'Одежда из кожи и замши',
            'parent_id' => 18,
            'order_by' => 3,
            'alias' => 'odezhda-iz-kozhi-i-zamshi',
        ],
        [
            'id' => 22,
            'name' => 'Пальто, плащи из кожи и замши',
            'parent_id' => 18,
            'order_by' => 4,
            'alias' => 'palto-plaschi-iz-kozhi-i-zamshi',
        ],
        [
            'id' => 23,
            'name' => 'Шубы и мех ',
            'parent_id' => 1,
            'order_by' => 4,
            'alias' => 'shuby-i-meh',
        ],
        [
            'id' => 24,
            'name' => 'Шубы',
            'parent_id' => 23,
            'order_by' => 1,
            'alias' => 'shuby',
        ],
        [
            'id' => 25,
            'name' => 'Меховые изделия',
            'parent_id' => 23,
            'order_by' => 2,
            'alias' => 'mehovye-izdelija',
        ],
        [
            'id' => 26,
            'name' => 'Домашний текстиль ',
            'parent_id' => 1,
            'order_by' => 5,
            'alias' => 'domashnij-tekstil',
        ],
        [
            'id' => 27,
            'name' => 'Одеяла, пледы',
            'parent_id' => 26,
            'order_by' => 1,
            'alias' => 'odejala-pledy',
        ],
        [
            'id' => 28,
            'name' => 'Подушки',
            'parent_id' => 26,
            'order_by' => 2,
            'alias' => 'podushki',
        ],
        [
            'id' => 29,
            'name' => 'Постельное белье',
            'parent_id' => 26,
            'order_by' => 3,
            'alias' => 'postelnoe-bele',
        ],
        [
            'id' => 30,
            'name' => 'Банные принадлежности',
            'parent_id' => 26,
            'order_by' => 4,
            'alias' => 'bannye-prinadlezhnosti',
        ],
        [
            'id' => 31,
            'name' => 'Шторы',
            'parent_id' => 26,
            'order_by' => 5,
            'alias' => 'shtory',
        ],
        [
            'id' => 32,
            'name' => 'Скатерти',
            'parent_id' => 26,
            'order_by' => 6,
            'alias' => 'skaterti',
        ],
        [
            'id' => 33,
            'name' => 'Мягкие игрушки',
            'parent_id' => 26,
            'order_by' => 7,
            'alias' => 'mjagkie-igrushki',
        ],
        [
            'id' => 34,
            'name' => 'Обувь, кожгалантерея ',
            'parent_id' => 1,
            'order_by' => 6,
            'alias' => 'obuv-kozhgalantereja',
        ],
        [
            'id' => 36,
            'name' => 'Обувь',
            'parent_id' => 34,
            'order_by' => 2,
            'alias' => 'obuv',
        ],
        [
            'id' => 37,
            'name' => 'Сумки',
            'parent_id' => 34,
            'order_by' => 3,
            'alias' => 'sumki',
        ],
        [
            'id' => 38,
            'name' => 'Ковры ',
            'parent_id' => 1,
            'order_by' => 7,
            'alias' => 'kovry',
        ],
        [
            'id' => 39,
            'name' => 'Ковры',
            'parent_id' => 38,
            'order_by' => 1,
            'alias' => 'kovry',
        ],
        [
            'id' => 40,
            'name' => 'Чехлы автомобильные и мебельные',
            'parent_id' => 38,
            'order_by' => 2,
            'alias' => 'chehly-avtomobilnye-i-mebelnye',
        ],
        [
            'id' => 41,
            'name' => 'VIP услуги ',
            'parent_id' => 1,
            'order_by' => 8,
            'alias' => 'vip-uslugi',
        ],
        [
            'id' => 42,
            'name' => 'Верхняя одежда кожа, мех',
            'parent_id' => 41,
            'order_by' => 1,
            'alias' => 'verhnjaja-odezhda-kozha-meh',
        ],
        [
            'id' => 43,
            'name' => 'Верхняя одежда текстиль',
            'parent_id' => 41,
            'order_by' => 2,
            'alias' => 'verhnjaja-odezhda-tekstil',
        ],
        [
            'id' => 44,
            'name' => 'Деловой костюм',
            'parent_id' => 41,
            'order_by' => 3,
            'alias' => 'delovoj-kostjum',
        ],
        [
            'id' => 45,
            'name' => 'Платья и юбки',
            'parent_id' => 41,
            'order_by' => 4,
            'alias' => 'platja-i-jubki',
        ],
        [
            'id' => 46,
            'name' => 'Повседневная одежда',
            'parent_id' => 41,
            'order_by' => 5,
            'alias' => 'povsednevnaja-odezhda',
        ],
        [
            'id' => 47,
            'name' => 'Обувь',
            'parent_id' => 41,
            'order_by' => 6,
            'alias' => 'obuv',
        ],
        [
            'id' => 48,
            'name' => 'Сумки',
            'parent_id' => 41,
            'order_by' => 7,
            'alias' => 'sumki',
        ],
        [
            'id' => 49,
            'name' => 'Аксессуары',
            'parent_id' => 41,
            'order_by' => 8,
            'alias' => 'aksessuary',
        ],
        [
            'id' => 50,
            'name' => 'Домашний текстиль',
            'parent_id' => 41,
            'order_by' => 9,
            'alias' => 'domashnij-tekstil',
        ],
        [
            'id' => 51,
            'name' => 'Чехлы автомобильные и мебельные',
            'parent_id' => 41,
            'order_by' => 10,
            'alias' => 'chehly-avtomobilnye-i-mebelnye',
        ],
    ];

    const CATEGORIES_PRODUCTS = [
        6 => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        7 => [14,15,16,17,18,19,20,21,22]
    ];

}
