<?php

namespace App\Products\Models;

use App\Facades\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Exception;

class ActualProductModel extends Model
{

    protected $table = 'city_category_product';
    public $timestamps = false;

}
