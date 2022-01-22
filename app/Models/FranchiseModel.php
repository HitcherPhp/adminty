<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FranchiseModel extends Model
{

    protected $table = 'franchises';

    public function franchise_attr()
    {
        return $this->hasMany('App\Models\FranchiseAttributeModel', 'id', 'id');
    }

    public static function create($data){
        DB::table('franchises')->insert($data);
    }


    public static function get_franchises(){
            if(PermissionModel::allow_select_franchises()){
                $user = Auth::user();
                if($user->group_id == 2 || $user->group_id == 3){
                    $franchises = FranchiseModel::join('city_franchise_factory_reception_user as cffru', 'franchises.id', '=', 'cffru.franchise_id')
                    ->select('franchises.id', 'franchises.name')
                    ->where('cffru.user_id', $user->id)
                    ->get()->toArray();
                    $franchises = array_map(function($e){
                        $e['mine'] = 1;
                        return $e;
                    }, $franchises);
                }
                else if($user->group_id == 1){
                    $franchises = FranchiseModel::join('city_franchise_factory_reception_user as cffru', 'franchises.id', '=', 'cffru.franchise_id')
                    ->join('staff as s', 'cffru.user_id', '=', 's.id')
                    ->select('franchises.id', 'franchises.name', 's.id as mine')
                    ->whereIn('s.group_id', [1,2,3])
                    ->get()->toArray();
                    $franchises = array_map(function($e){
                        if($e['mine'] == 1){
                            return $e;
                        }else{
                            $e['mine'] = 0;
                            return $e;
                        }
                    }, $franchises);
                }
            }else{
                return false;
            }
            return $franchises;
        }

}
