<?php


namespace App\Http\Controllers\Adminty;


use App\Facades\Auth;
use App\Facades\Message;
use App\Facades\Phone;
use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use App\Models\ActualProductModel;
use App\Services\CustomerProfileForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{


    public function customer_profile() {

        $customer = Auth::user();

        if (Message::SERVER_ERROR === $customer) {
            return response()->json($customer);
        }

        $customer_profile = CustomerProfileForm::getProfile($customer);

        return response()->json($customer_profile);

    }


    public function edit_customer_name(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules['name'] = ['required', 'regex:/^[А-ЯA-Z][а-яa-z]{2,}([-][А-ЯA-Z][а-яa-z]{2,})?\s[А-ЯA-Z][а-яa-z]{2,}(\s[А-ЯA-Z][а-яa-z]{2,})?$/u'];
        $messages['name.required'] = 'fill_able';
        $messages['name.regex'] = 'incorrectly';

        $validator = Validator::make($request->only('name'), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $updated = Auth::update('name', $request->get('name'));

        if ($updated === Message::SERVER_ERROR) {
            return $updated;
        }

        return $this->customer_profile();
    }


    public function edit_customer_phone(Request $request) {

        $rules['country_code'] = 'required';
        $messages['country_code.required'] = 'fill_able';

        $validator = Validator::make($request->only('country_code'), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        unset($rules['country_code']);
        unset($messages['country_code.required']);

        $rules['phone'] = ['required', 'regex:'.Phone::PHONE_MASKS[$request->get('country_code')]];
        $messages['phone.required'] = 'fill_able';
        $messages['phone.regex'] = 'incorrectly';

        $phone = $request->only('phone');

        $validator = Validator::make($request->only('phone'), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $updated = Auth::update('phone', $request->get('phone'));

        if ($updated === Message::SERVER_ERROR) {
            return $updated;
        }

        return $this->customer_profile();
    }


    public function edit_customer_email(Request $request) {

        $rules['email'] = ['required', 'email:rfc,dns'];
        $messages['email.required'] = 'fill_able';
        $messages['email.email'] = 'incorrectly';

        $validator = Validator::make($request->only('email'), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $updated = Auth::update('email', $request->get('email'));

        if ($updated === Message::SERVER_ERROR) {
            return $updated;
        }

        return $this->customer_profile();
    }


    public function edit_customer_gender(Request $request) {

        $rules['gender'] = 'required';
        $messages['gender.required'] = 'fill_able';

        $validator = Validator::make($request->only('gender'), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $updated = Auth::update('gender', $request->get('gender'));

        if ($updated === Message::SERVER_ERROR) {
            return $updated;
        }

        return $this->customer_profile();
    }


    public function edit_customer_birthday(Request $request) {

        $rules['birthday'] = ['required', 'date'];
        $messages['birthday.required'] = 'fill_able';
        $messages['birthday.date'] = 'incorrectly';

        $validator = Validator::make($request->only('birthday'), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        $updated = Auth::update('birthday', $request->get('birthday'));

        if ($updated === Message::SERVER_ERROR) {
            return $updated;
        }

        return $this->customer_profile();
    }


    public function logout() {
        return response(CustomerModel::logout())->withCookie(cookie()->forget('api_token'));
    }


    public function edit_product_comment(Request $request) {

        if (!$request->isJson()) {
            return Message::IS_NOT_JSON;
        }

        $rules = [
            'comment' => 'required',
            'mark' => 'required'
        ];

        $messages = [
            'comment.required' => 'fill_able',
            'mark.required' => 'fill_able'
        ];

        if ($request->has('product_id') and $request->has('customer_id')) {
            $rules['product_id'] = 'required';
            $messages['product_id.required'] = 'fill_able';
            $rules['customer_id'] = 'required';
            $messages['customer_id.required'] = 'fill_able';
        }
        else {
            $rules['comment_id'] = 'required';
            $messages['comment_id.required'] = 'fill_able';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()) {
            return $validator->errors();
        }

        if($request->has('comment_id')) {
            $comment_id = ActualProductModel::edit_product_comment($request->all());
        }
        else {
            $comment_id = ActualProductModel::add_product_comment($request->all());
        }

        if (Message::SERVER_ERROR === $comment_id) {
            return Message::SERVER_ERROR;
        }

        $comment = ActualProductModel::product_comment(['comment_id' => $comment_id]);

        if (Message::SERVER_ERROR === $comment) {
            return Message::SERVER_ERROR;
        }

        return response()->json($comment);

    }

}
