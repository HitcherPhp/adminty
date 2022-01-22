<?php

namespace App\Http\Controllers\Adminty;

use App\Facades\Phone;
use App\Models\CategoryModel;
use App\Models\CountryModel;
use App\Models\CustomerModel;
use App\Models\DiscountModel;
use App\Models\ActualProductModel;
use App\Models\CityModel;
use App\Models\ReceptionModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Facades\Message;

class ApiController extends Controller
{


    public function categories(Request $request)
    {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = ['city_id' => 'required'];

        $messages = ['city_id.required' => 'fill_able'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $categories = CategoryModel::categories($request->all());

        if (Message::NOT_FOUND === $categories) {
            return Message::NOT_FOUND;
        }

        return $categories;

    }


    public function main_categories(Request $request)
    {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = ['city_id' => 'required'];

        $messages = ['city_id.required' => 'fill_able'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $main_categories = CategoryModel::main_categories($request->all());

        if (Message::NOT_FOUND === $main_categories) {
            return Message::NOT_FOUND;
        }

        $main_cp = [];

        foreach ($main_categories as $mc) {

            $mc->products = ActualProductModel::popular_products([
                        'city_id' => 7,
                        'category_id' => $mc->id,
                        'limit' => 6,
                    ]);

            if (Message::NOT_FOUND === $mc->products) {
                return Message::NOT_FOUND;
            }

            $main_cp[] = $mc;
        }

        return $main_cp;

    }


    public function products(Request $request)
    {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = [
            'city_id' => 'required',
            'category_id' => 'required',
        ];
        $messages = [
            'city_id.required' => 'fill_able',
            'category_id.required' => 'fill_able'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $products = ActualProductModel::products($request->all());


        if (Message::NOT_FOUND === $products) {
            return Message::NOT_FOUND;
        }

        return $products;
    }


    public function product_item(Request $request)
    {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = [
            'id' => 'required',
        ];
        $messages = [
            'id.required' => 'fill_able',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $product_item = ActualProductModel::product_card($request->all());

        if (Message::NOT_FOUND === $product_item) {
            return Message::NOT_FOUND;
        }

        return response()->json($product_item);

    }


    public function product_comments(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = [
            'id' => 'required',
            'limit' => 'required',
            'page' => 'required'
        ];
        $messages = [
            'id.required' => 'fill_able',
            'limit.required' => 'fill_able',
            'page.required' => 'fill_able'
        ];

        if($request->has('page')) {
            unset($rules['limit']);
            unset($messages['limit.required']);
        }
        elseif ($request->has('limit')) {
            unset($rules['page']);
            unset($messages['page.required']);
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $comments = ActualProductModel::product_comments($request->all());

        if (Message::NOT_FOUND === $comments) {
            return Message::NOT_FOUND;
        }

        return [
            'comments' => $comments->items,
            'last_page' => $comments->last_page
        ];

    }


    public function city_receptions(Request $request)
    {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = ['city_id' => 'required'];

        $messages = ['city_id.required' => 'fill_able'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $receptions = ReceptionModel::city_receptions($request->all());

        if (Message::NOT_FOUND === $receptions) {
            return Message::NOT_FOUND;
        }

        return $receptions;

    }


    public function order(Request $request)
    {
        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

    }

    public function cities()
    {

        $countries = CountryModel::countries();

        if (Message::NOT_FOUND === $countries) {
            return $countries;
        }

        $cities = CityModel::cities();

        if (Message::NOT_FOUND === $cities) {
            return $cities;
        }

        return [
            'countries' => $countries,
            'cities' => $cities
        ];

    }


    public function register(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = ['country_code' => 'required'];
        $messages = ['country_code.required' => 'fill_able'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $rules = [
            'phone' => ['required', 'unique:customers', 'regex:'.Phone::PHONE_MASKS[$request->get('country_code')]],
            'name' => ['required', 'regex:/^[А-ЯA-Z][а-яa-z]{2,}([-][А-ЯA-Z][а-яa-z]{2,})?\s[А-ЯA-Z][а-яa-z]{2,}(\s[А-ЯA-Z][а-яa-z]{2,})?$/u'],
            'password' => 'required|confirmed|min:8|max:36',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'phone.required' => 'fill_able',
            'phone.regex' => 'incorrectly',
            'phone.unique' => 'in_use',
            'name.required' => 'fill_able',
            'name.regex' => 'incorrectly',
            'password.required' => 'fill_able',
            'password.confirmed' => 'not_confirm',
            'password.min' => 'min',
            'password.max' => 'max'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return response(CustomerModel::registration($request->all()))->withCookie(cookie('api_token', session()->get('api_token')));
    }


    public function send_auth_code() {

        return CustomerModel::send_auth_code();
    }


    public function check_auth_code(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = [
            'code' => 'required',
        ];

        $messages = [
            'code.required' => 'fill_able',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return CustomerModel::check_auth_code($request->all());
    }


    public function sign_in(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = ['country_code' => 'required'];
        $messages = ['country_code.required' => 'fill_able'];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $rules = [
            'phone' => ['required', 'regex:'.Phone::PHONE_MASKS[$request->get('country_code')]],
            'password' => 'required|min:8|max:36'
        ];

        $messages = [
            'phone.required' => 'fill_able',
            'phone.regex' => 'incorrectly',
            'password.required' => 'fill_able',
            'password.min' => 'min',
            'password.max' => 'max'
        ];

        if ($request->has('email')) {

            unset($rules['phone']);

            $rules['email'] = [
                'email' => ['required', 'email:rfc,dns'],
            ];

            unset($messages['phone.required']);
            unset($messages['phone.phone']);

            $messages['email.required'] = 'fill_able';
            $messages['email.email'] = 'incorrectly';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }


        return response(CustomerModel::authorisation($request->all()))->withCookie(cookie('api_token', session()->get('api_token')));

    }


}
