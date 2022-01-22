<?php


namespace App\Discounts\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;

class PromotionModel extends Model
{
    protected $table = 'promotions';
    public $timestamps = false;
}
