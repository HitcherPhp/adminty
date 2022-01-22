<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Facades\Permission;
use Exception;
use App\Facades\Link;

class LinkModel extends Model
{
    protected $table = 'links';
    public $timestamps = false;


    private static function links_by_permissions(&$links, $link) {

        foreach ($links as $id => $l) {
            if ($link === $l->link) {
                unset($links[$id]);
            }
        }

    }

    public static function links() {
        try {

            $links = DB::table('links as l')->select('link', 'name', 'icon')->orderBy('order_by')->get()->toArray();

            if(!in_array(Permission::FRANCHISES_VIEW, Permission::permissions())) {
                self::links_by_permissions($links,Link::FRANCHISES);
            }
            if(!in_array(Permission::FACTORIES_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::FACTORIES);
            }
            if(!in_array(Permission::RECEPTIONS_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::RECEPTIONS);
            }
            if(!in_array(Permission::STAFF_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::STAFF);
            }
            if(!in_array(Permission::CUSTOMERS_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::CUSTOMERS);
            }
            if(!in_array(Permission::ORDERS_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::ORDERS);
            }
            if(!in_array(Permission::PROMO_CODES_VIEW, Permission::permissions())){
                self::links_by_permissions($links, Link::PROMO_CODES);
            }

            return $links;

        }
        catch (Exception $e) {

            return Message::NOT_FOUND;
        }

    }

}
