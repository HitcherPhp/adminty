<?php


namespace App\Services;


use App\Facades\Message;
use App\Interfaces\ProfileForm;

class CustomerProfileForm implements ProfileForm
{
    public static function getProfile(&$user) {

        try {
            $default_id = "000000000000000000";

            $user_id = (string)$user['id'];

            $user_id = substr($default_id, 0, -strlen($user_id)).$user_id;

            if ($user['gender'] === 'male') {
                $gender = 'Мужской';
            }
            elseif($user['gender'] === 'female') {
                $gender = 'Женский';
            }
            else {
                $gender = null;
            }

            return [
                'id' => $user_id,
                'name' => $user['name'],
                'phone' => $user['phone'],
                'birthday' => $user['birthday'],
                'email' => $user['email'],
                'gender' => $gender,
                'profile_type' => $user['type_of_ownership']
            ];
        }
        catch (\Exception $e) {
            return Message::SERVER_ERROR;
        }

    }
}
