<?php

use App\Discounts\Controllers\SetDiscountsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\ProductModel;
use App\Categories\Models\CategoryModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['api', 'cors'])->group(function() {

    Route::get('test', function (Request $request) {


        //$response = (new SetDiscountsController())();
        //$response = CategoryModel::from('categories as c')->lastCategories()->get();

        $busket = \App\Basket\Models\ActualBasketModel::all();

        return response()->json($busket);

    });


    Route::match(['GET', 'POST'], 'catalog/list', 'Adminty\ApiController@categories');
    Route::match(['GET', 'POST'], 'catalog/main', 'Adminty\ApiController@main_categories');

    Route::post('product/list', 'Adminty\ApiController@products');
    Route::get('product/item', 'Adminty\ApiController@product_item');

    Route::get('comments/list', 'Adminty\ApiController@product_comments');

    Route::match(['GET', 'POST'], 'cities', 'Adminty\ApiController@cities');

    Route::match(['GET', 'POST'], 'receptions/list', 'Adminty\ApiController@city_receptions');

    Route::match(['GET', 'POST'], 'auth/register', 'Adminty\ApiController@register');
    Route::match(['GET', 'POST'], 'auth/authorize', 'Adminty\ApiController@sign_in');

    Route::get('auth/send_code', 'Adminty\ApiController@send_auth_code');
    Route::get('auth/check_code', 'Adminty\ApiController@check_auth_code');

    Route::post('basket/list', [\App\Basket\Controllers\BasketController::class, 'get_basket']);
    Route::get('basket/calculate', 'Adminty\ApiController@calculate_basket');

    Route::middleware('api_auth')->group(function () {

        Route::post('comment', 'Adminty\ProfileController@edit_product_comment');

        Route::get('auth/logout','Adminty\ProfileController@logout');

        Route::get('profile/user', 'Adminty\ProfileController@customer_profile');

        Route::get('profile/edit/name', 'Adminty\ProfileController@edit_customer_name');

        Route::get('profile/edit/phone', 'Adminty\ProfileController@edit_customer_phone');

        Route::get('profile/edit/email', 'Adminty\ProfileController@edit_customer_email');

        Route::get('profile/edit/gender', 'Adminty\ProfileController@edit_customer_gender');

        Route::get('profile/edit/birthday', 'Adminty\ProfileController@edit_customer_birthday');

    });

});

