<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Facades\Error;
use Illuminate\Support\Facades\Log;

class SelectFranchiseModel extends Model
{
    protected $table = 'select_franchises';
    public $timestamps = false;
    protected $fillable = ['user_id', 'franchise_id'];


    public static function set_franchise($franchise_id) {
        try {
            SelectFranchiseModel::updateOrInsert(
                    ['select_franchises.user_id' => Auth::user()->id],
                    ['select_franchises.franchise_id' => $franchise_id]
                );
        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }

    public static function get_franchise($id) {
        try {
            $franchise_id = SelectFranchiseModel::select('franchise_id')
                ->where('user_id', '=', $id)
                ->get()
                ->toArray();

            // dd($franchise_id);

            if(empty($franchise_id)){
                return Message::NOT_FOUND;
            }
            return $franchise_id;
        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }


    }

























}
