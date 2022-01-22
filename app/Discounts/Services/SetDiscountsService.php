<?php


namespace App\Discounts\Services;


use App\Discounts\Models\DiscountModel;
use App\Facades\Message;
use App\Models\CityModel;
use App\Products\Models\ActualProductModel;
use Illuminate\Support\Facades\DB;

class SetDiscountsService
{


    public function archive_old_discounts(SetDiscountsAdapterService &$adapterService) {
        try {
            $set_city_ids = $adapterService->getSetCityIds();

            $updated = DiscountModel::from('discounts as d')->join('promotions as p', 'p.id', '=', 'd.promotion_id')
                ->whereRaw("STR_TO_DATE(d.end, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s') and d.city_id in ($set_city_ids)")
                ->where('p.perpetual', '=', false)
                ->update([
                    'd.deleted' => true
                ]);

            $adapterService->setMessageSuccess();

        }
        catch (\Exception $e) {

            $adapterService->writeLog($e);

        }

    }


    public function unset_discounts(SetDiscountsAdapterService &$adapterService) {

        try {
            $city_ids = $adapterService->getCityIds();

            $updated = ActualProductModel::from('city_category_product as ccp')
                ->whereIn('ccp.city_id', $city_ids)
                ->update([
                    'ccp.discount_id' => null,
                    'ccp.promotion_ids' => DB::raw(
                        "CONCAT('-1', ',', COALESCE(" .
                "(SELECT GROUP_CONCAT(d.id ORDER BY d.id SEPARATOR ',') ".
                "FROM (select * from discounts where ccp.city_id = city_id and FIND_IN_SET(ccp.id, product_ids) <> 0) as d ".
                "JOIN promotions as p on p.id = d.promotion_id ".
                "where d.deleted = FALSE ".
                "and p.`type` in (SELECT DISTINCT `type` from promotions where deleted = false and perpetual = true) ".
                "and d.id = (select d.id from (select * from discounts where ccp.city_id = city_id ".
                "and FIND_IN_SET(ccp.id, product_ids) <> 0) as ds join promotions as ps on ps.id = ds.promotion_id ".
                "where p.`type` = ps.`type` ".
                "ORDER BY ds.start DESC LIMIT 1)), ''))")
                ]);

            $adapterService->setMessageSuccess();

        }
        catch (\Exception $e) {

            $adapterService->writeLog($e);

        }
    }


    public function set_discounts(SetDiscountsAdapterService &$adapterService) {

        try {
            $set_city_ids = $adapterService->getSetCityIds();

            $updated = DB::update(
                "UPDATE city_category_product AS ccp".
                " JOIN (select id, `start`, `end`, percent, product_ids, promotion_id, deleted".
                " FROM discounts WHERE city_id in (1,2,3,4,5,6,7,8,9,10,11,12)) AS d".
                " ON FIND_IN_SET(ccp.id, d.product_ids) <> 0".
                " JOIN promotions as p on p.id = d.promotion_id".
                " SET ccp.discount_id = d.id,".
                " promotion_ids = CONCAT(COALESCE(ccp.promotion_ids, '-1'), ',', d.id)".
                " WHERE ccp.published = true".
                " and d.deleted = false".
                " and p.perpetual = false".
                " and p.deleted = false".
                " and d.percent <> 0".
                " and STR_TO_DATE(d.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')".
                " and STR_TO_DATE(d.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')".
                " and CONCAT(d.start, d.percent) =".
                " (select CONCAT(ds.start, ds.percent)".
                " FROM (select id, `start`, `end`, percent, product_ids, promotion_id, deleted".
                " FROM discounts where city_id in ($set_city_ids)) AS ds".
                " JOIN promotions as ps on ps.id = ds.promotion_id".
                " where FIND_IN_SET(ccp.id, ds.product_ids) <> 0".
                " and ds.deleted = false".
                " and ps.perpetual = false".
                " and ps.deleted = false".
                " and ds.percent <> 0".
                " and STR_TO_DATE(ds.start, '%Y-%m-%d %H:%i:%s') <= STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')".
                " and STR_TO_DATE(ds.end, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s')".
                " ORDER BY ds.start DESC, ds.percent DESC LIMIT 1)");

            $adapterService->setMessageSuccess();

        }
        catch (\Exception $e) {

            $adapterService->writeLog($e);

        }
    }

}
