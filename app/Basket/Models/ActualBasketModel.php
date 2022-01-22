<?php


namespace App\Basket\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActualBasketModel extends Model
{

    protected $table = 'city_category_product';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'city_id',
        'category_id',
        'product_id',
        'discount_id',
        'promotion_ids',
        'service_type_id',
        'is_vip',
        'price',
        'html_title',
        'meta_title',
        'published'
    ];


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('api_basket', function (Builder $builder) {
            $builder->from('city_category_product', 'ccp')
                ->select(
                    'ccp.id as id',
                    DB::raw("ROUND(ccp.price, 0) as price")
                )
                ->actualDiscount()
                ->categoryService()
                ->productCard();
        });
    }


    /**
     * Scope a query to add discounts for actual products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $alias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProductCard(Builder $query) {

        return $query
            ->addSelect(
                'p.name as name',
                DB::raw("CONCAT(i.path, i.name) as image_url"),
                DB::raw("SUBSTRING_INDEX(p.description,'\n', 1) as description"),
                DB::raw("SUBSTRING_INDEX(p.description,'\n', -1) as full_description")
            )
            ->join('products as p', 'ccp.product_id', '=', 'p.id')
            ->leftJoin('images as i', 'p.image_id', '=', 'i.id');
    }



    /**
     * Scope a query to add service type for actual products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $alias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategoryService(Builder $query) {
        return $query->addSelect(
            'st.id as service_id',
            'st.name as service_name'
            )
            ->join('categories as c', 'ccp.category_id', '=', 'c.id')
            ->join('service_type as st', function ($join) {
                $join->on(DB::raw("FIND_IN_SET(st.main_category_id, c.parent_ids)"), '<>', DB::raw(0));
            });
    }



    /**
     * Scope a query to add discounts for actual products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $alias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActualDiscount(Builder $query) {

        return $query->addSelect(
            DB::raw(
                "CASE".
                " WHEN d.price = 0 THEN ROUND(ccp.price * (1 - d.percent / 100), 0)".
                " WHEN d.percent = 0 THEN ROUND(ccp.price - d.price, 0)".
                " END AS new_price"
            ),
            'd.percent as discount_percent',
            'd.price as discount_price'
        )->leftJoin('discounts as d', "ccp.discount_id", '=', 'd.id');

    }

}
