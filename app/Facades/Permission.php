<?php


namespace App\Facades;


use App\Models\FranchiseModel;
use App\Models\LinkModel;
use App\Models\PermissionModel;
use App\Models\SelectFranchiseModel;
use App\Models\CityFranchiseFactoryReceptionUserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Permission
{

    const FRANCHISES_VIEW = 'franchises|view';
    const FACTORIES_VIEW = 'factories|view';
    const RECEPTIONS_VIEW = 'receptions|view';
    const STAFF_VIEW = 'staff|view';
    const CUSTOMERS_VIEW = 'customers|view';
    const ORDERS_VIEW = 'orders|view';
    const PROMO_CODES_VIEW = 'promo_codes|view';
    const SELECT_FRANCHISE_VIEW = 'select_franchises|view';
    const ALL_STAFF_TABLE_VIEW = 'all_staff_table|view';
    const ALL_FACTORIES_TABLE_VIEW = 'all_factories_table|view';


    private static $permission = [];

    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }


    public static function permissions() {

        if (!isset(self::$permission['permissions'])) {

            $permission = PermissionModel::permissions();

            if ($permission === Message::NOT_FOUND) {
                return self::$permission['permissions'] = [];
            }

            self::$permission['permissions'] = array_column($permission, 'permission');
        }

        return self::$permission['permissions'];

    }



}
