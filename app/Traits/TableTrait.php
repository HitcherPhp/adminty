<?php

namespace App\Traits;
use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use App\Models\CityFranchiseFactoryReceptionUserModel;
// use App\Facades\Auth;
use App\Models\SelectFranchiseModel;
use App\Facades\Permission;
use Illuminate\Pagination\Paginator;

Trait TableTrait
{

    public static function get_table($query, $where, $data, $const, $user_data){

        $selected_franchise = SelectFranchiseModel::get_franchise($user_data->id);

        if($selected_franchise !== Message::NOT_FOUND){
            if($selected_franchise[0]['franchise_id'] != 0){
                # выбрана какая-то франшиза
                array_push($where, ['cffru.franchise_id', '=', $selected_franchise[0]['franchise_id']]);
            }else{
                # "все франшизы"
                $query = self::set_whereIn_clause($query, $user_data, $const);
                if (Message::NOT_FOUND === $query) {
                    return $query;
                }else if(Message::SERVER_ERROR === $query){
                    return $query;
                }
            }
        }else{
            # вошел в первый раз, ни разу не выбирал франшизу
            $query = self::set_whereIn_clause($query, $user_data, $const);
            if (Message::NOT_FOUND === $query) {
                return $query;
            }else if(Message::SERVER_ERROR === $query){
                return $query;
            }
        }

        try {
            $paginator = $query->where($where)->paginate($data['limit']);
            if(empty($paginator)){
                return Message::NOT_FOUND;
            }
            // return $paginator;
        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

        if (Message::NOT_FOUND === $paginator) {
            return $paginator;
        }else if(Message::SERVER_ERROR === $paginator){
            return $paginator;
        }

        $response = new \stdClass();

        $response->{'items'} = $paginator->items();
        $response->{'last_page'} = $paginator->lastPage();

        // dd($response);
        return $response;






    }


    public static function set_whereIn_clause($query, $user_data, $const){
        if(!in_array($const, Permission::permissions())){
            # вошедший - администратор фрашшизы, необходимо получить айдишки его франшиз
            $franchise_ids = CityFranchiseFactoryReceptionUserModel::get_admin_franchises($user_data->id);
            if (Message::NOT_FOUND === $franchise_ids) {
                return $franchise_ids;
            }else if(Message::SERVER_ERROR === $franchise_ids){
                return $franchise_ids;
            }
            $franchise_ids = array_column($franchise_ids, 'franchise_id');
            // dd($franchise_ids);
            return $query->whereIn('cffru.franchise_id', $franchise_ids);
        }else{
            return $query;
        }
    }









}
