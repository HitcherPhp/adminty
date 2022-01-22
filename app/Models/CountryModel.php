<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Facades\Message;

class CountryModel extends Model
{
    protected $table = 'countries';
    public $timestamps = false;


    public static function countries()
    {
        try {

            $query = DB::table('countries as c')
                ->select(
                    'c.id as country_id',
                    'c.alias as country_code',
                    'c.name as country_name',
                    'c.currency_symbol as currency_symbol',
                    'c.phone_geocode as phone_geocode',
                    'c.phone_mask as phone_mask'
                )
                ->get()->toArray();

            if (empty($query)) {
                return Message::NOT_FOUND;
            }

            return $query;

        } catch (Exception $e) {

            return Message::SERVER_ERROR;
        }
    }
}
