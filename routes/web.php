<?php


use App\Models\ActualProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ScheduleDayTimeModel;
use Carbon\Carbon;
use App\Models\OrderModel;
use App\Models\CategoryModel;
use App\Models\OrderProductsModel;
use App\Models\ServiceType;
use App\Models\BasketMathModel;
use App\Basket\Events\BasketListEvent;
use App\Basket\Models\OrderBasketEditQueriesModel;
use App\Basket\Services\BasketBildingService;
use App\Basket\Services\BasketHandlerService;
use App\Facades\Message;

Auth::routes(['register' => false]);

Route::get('test', function (Request $request) {
    $with_p_c = [
        "id" => 1,
        "products" => [
            [
                "basket_id" => 68,
                "product_id" => 110,
                "count" => 3
            ],
            [
                "basket_id" => 98,
                "product_id" => 92,
                "count" => 2
            ],
            [
                "basket_id" => 101,
                "product_id" => 102,
                "count" => 4
            ],
            [
                "basket_id" => 110,
                "product_id" => 123,
                "count" => 3
            ],
            [
                "basket_id" => 0,
                "product_id" => 105,
                "count" => 2
            ],
            [
                "basket_id" => 0,
                "product_id" => 103,
                "count" => 5
            ],
        ]
    ];



    $without_p_c = [
        "id" => 4,
        "products" => [
            [
                "basket_id" => 23,
                "product_id" => 260,
                "count" => "3"
            ],
            [
                "basket_id" => 35,
                "product_id" => 224,
                "count" => 4
            ],
            [
                "basket_id" => 36,
                "product_id" => 264,
                "count" => 1
            ],
            [
                "basket_id" => 77,
                "product_id" => 246,
                "count" => 2
            ],
            [
                "basket_id" => 92,
                "product_id" => 235,
                "count" => 1
            ],
            [
                "basket_id" => 0,
                "product_id" => 251,
                "count" => 1
            ],
            [
                "basket_id" => 0,
                "product_id" => 244,
                "count" => 2
            ]
        ]
    ];



    // $a = null;
    // $s = '0.00';
    // dd(0 == $s);

    // $str = '1,2,4,5';
    // // $str = '1';
    //
    // $ds = explode(',', $str);
    // dd(in_array('1', $ds));




    // $d3 = BasketHandlerService::bilding_estimate_products_data($without_p_c);
    $d3 = BasketHandlerService::bilding_estimate_products_data($with_p_c);
    dd($d3);

    $data = [
        "id" => 2,
        'need_service_headers' => false,
        'need_estimate_headers' => false,

    ];
    $d3 = BasketBildingService::assemble_basket_data($data);
    dd($d3);

    // $params = [
    //         [
    //             "id" => 14,
    //             "count" =>  2
    //         ],
    //         [
    //             "id" => 23,
    //             "count" =>  1
    //         ]
    // ];
    //
    // $event = event(new BasketListEvent(['products' => $params]));
    //
    // $response = $event[0];
    // dd($response);


    dd('in test url');

});

Route::middleware('auth:web')->group(function() {

    // Route::get('test', function (Request $request) {
    //
    // });

    Route::get('/', 'HomeController@index')->name('home');
    Route::post('get_links', 'Adminty\AdmintyController@navigation_links')->name('get_links');
    Route::post('get_franchises', 'Adminty\AdmintyController@get_franchises')->name('get_franchises');
    Route::post('get_current_user', 'Adminty\AdmintyController@get_current_user')->name('get_current_user');
    Route::post('update_franchise_in_db', 'Adminty\AdmintyController@update_franchise_in_db')->name('update_franchise_in_db');


    Route::middleware('permissions')->group(function () {
        Route::match(['GET', 'POST'], 'staff', 'Adminty\StaffController@index');
        Route::post('staff/update_table', 'Adminty\StaffController@update_table')->name('staff.update_table');
        // Route::match(['GET', 'POST'],'staff/check_franchise_id', 'Adminty\StaffController@check_franchise_id')->name('staff.check_franchise_id');
        Route::post('staff/edit', 'Adminty\StaffController@edit')->name('staff.edit');
        Route::post('staff/create', 'Adminty\StaffController@create')->name('staff.create');
        Route::post('staff/store', 'Adminty\StaffController@store')->name('staff.store');


        Route::match(['GET', 'POST'],'factories', 'Adminty\FactoryController@index');
        Route::match(['GET', 'POST'],'factories/update_table', 'Adminty\FactoryController@update_table')->name('factories.update_table');
        Route::post('factories/edit', 'Adminty\FactoryController@edit')->name('factories.edit');


        Route::match(['GET', 'POST'],'receptions', 'Adminty\ReceptionController@index');
        Route::match(['GET', 'POST'],'receptions/update_table', 'Adminty\ReceptionController@update_table')->name('receptions.update_table');
        // Route::post('receptions/store', 'Adminty\ReceptionController@store')->name('receptions.store');


        Route::match(['GET', 'POST'],'orders', 'Adminty\OrderController@index');
        Route::post('orders/update_table', 'Adminty\OrderController@update_table');
        Route::post('orders/edit', 'Adminty\OrderController@edit');
        // Route::post('orders/edit', 'BasketController@edit');

        Route::post('orders/store', 'Adminty\OrderController@store');
        Route::post('orders/create', 'Adminty\OrderController@create');
        Route::post('orders/search_autocomplete', 'Adminty\OrderController@search_autocomplete');
        Route::post('orders/get_added_product_data', 'Adminty\OrderController@get_added_product_data');

        Route::post('get_basket_estimate_price', [\App\Basket\Controllers\BasketController::class, 'get_basket_estimate_price']);


        Route::match(['GET', 'POST'], 'customers', 'Adminty\CustomerController@index');
        Route::post('customers/update_table', 'Adminty\CustomerController@update_table')->name('customers.update_table');
        Route::post('customers/edit', 'Adminty\CustomerController@edit')->name('customers.edit');

        Route::resource('promo_codes', 'Adminty\PromoCodeController', ['except' => ['destroy', 'show', 'update', 'edit']]);
        Route::match(['GET', 'POST'],'promo_codes/update_table', 'Adminty\PromoCodeController@update_table')->name('promo_codes.update_table');

        // Route::get('select_franchise/{id}/name/{name}', 'Adminty\SelectFranchiseController@select_franchise')->name('select_franchise');
        // Route::post('show_franchises', 'Adminty\SelectFranchiseController@show_franchises')->name('show_franchises');

        Route::match(['GET', 'POST'],'franchises', 'Adminty\FranchiseController@index');
        Route::match(['GET', 'POST'],'franchises/update_table', 'Adminty\FranchiseController@update_table')->name('franchises.update_table');
    });

});
