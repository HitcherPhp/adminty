<?php

namespace App\Categories\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class CategoryModel extends Model
{
    protected $table = 'categories';

    public $timestamps = false;


    public function scopeLastCategories(Builder $query) {

        return $query->whereNotNull('c.parent_id')
            ->whereRaw("(select COUNT(cs.id) from categories as cs where FIND_IN_SET(c.id, cs.parent_ids) <> 0) = 0");

    }

    public function scopeServiceType(Builder $query) {

        return $query
            ->join('service_type as st', DB::raw("FIND_IN_SET(st.main_category_id, c.parent_ids)"), '<>', DB::raw("0"));

    }

}
