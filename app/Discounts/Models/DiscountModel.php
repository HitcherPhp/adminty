<?php

namespace App\Discounts\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;


class DiscountModel extends Model
{
    protected $table = 'discounts';
    public $timestamps = false;


}
