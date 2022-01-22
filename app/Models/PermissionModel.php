<?php

namespace App\Models;

use App\Facades\Message;
use App\Facades\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class PermissionModel extends Model
{

    protected $table='permissions';
    public $timestamps = false;

    const FRANCHISES = 'franchises';
    const FACTORIES = 'factories';
    const RECEPTIONS = 'receptions';
    const STAFF = 'staff';
    const CUSTOMERS = 'customers';
    const ORDERS = 'orders';
    const PROMO_CODES = 'promo_codes';



    public static function permissions()
    {
        try {

            return DB::table('groups_permissions as gp')->join('permissions as p', 'gp.permission_id', '=', 'p.id')
                ->select('p.name as permission')
                ->where('gp.group_id', '=', Auth::user()->group_id)
                ->get()->toArray();

        } catch (Exception $e) {

            return Message::SERVER_ERROR;
        }


    }

    // public static function get_links_array_idx($array, $const){
    //     return array_search($const, array_column($array, 'link')); // можно array_column использовать один раз в другом месте
    // }

    // public static function get_available_links($links) {
    //     if(!in_array(Permission::FRANCHISES_VIEW, Permission::permissions())) {
    //         $idx = self::get_links_array_idx($links, self::FRANCHISES);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::FACTORIES_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::FACTORIES);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::RECEPTIONS_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::RECEPTIONS);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::STAFF_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::STAFF);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::CUSTOMERS_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::CUSTOMERS);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::ORDERS_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::ORDERS);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     if(!in_array(Permission::PROMO_CODES_VIEW, Permission::permissions())){
    //         $idx = self::get_links_array_idx($links, self::PROMO_CODES);
    //         if($idx !== false){
    //             unset($links[$idx]);
    //         }
    //         $links = array_values($links);
    //     }
    //     return $links;
    // }

    public static function allow_select_franchises(){
        # Используется в FranchiseModel
        if(in_array(Permission::SELECT_FRANCHISE_VIEW, Permission::permissions())){
            return true;
        }else{
            return false;
        }

    }








}
