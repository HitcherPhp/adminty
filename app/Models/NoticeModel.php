<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeModel extends Model
{
    protected $table = 'notifications';
    public $timestamps = false;

    public function save_update_event($id_array) {

    }


}
