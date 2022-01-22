<?php

namespace App\Models;

use App\Facades\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Log;

class ReceptionModel extends Model
{

    protected $table = 'receptions';

    public function insert_get_id($data) {
        $last_reception_id = DB::table('receptions')->insertGetId($data);
        return $last_reception_id;
    }


    public static function city_receptions($attr) {
        try {

            $query = DB::table('city_franchise_factory_reception_user as cffru')
                ->select(
                    'r.id as id',
                    DB::raw("COALESCE(a.name, '') as name"),
                    DB::raw("CONCAT('г. ', c.name, ', ', a.name) as reception_address"),
                    'r.phone as phone',
                    'r.household as household',
                    DB::raw("CONCAT(r.discount_percent, '%') as discount_percent"),
                    'a.latitude as latitude',
                    'a.longitude as longitude'
                )
                ->leftJoin('receptions as r', 'r.id', '=', 'cffru.reception_id')
                ->leftJoin('cities as c',  'c.id', '=', 'cffru.city_id')
                ->join('addresses as a', 'a.id', '=', 'r.address_id')
                ->leftJoin('timezones as tz', 'tz.id', '=', 'c.timezone_id')
                ->whereRaw("cffru.city_id = ".$attr['city_id'])
                ->whereNotNull('cffru.franchise_id')
                ->whereNull('cffru.factory_id')
                ->whereNotNull('cffru.reception_id')
                ->whereNull('cffru.user_id')
                ->whereRaw("r.deleted = false");

            if (isset($attr['household'])) {
                $query->where('r.household', '=', $attr['household']);
            }

            return $query->get()->toArray();

        }
        catch (Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

    }


    public static function set_reception_select($id){
        $franchise_id = SelectFranchiseModel::select('franchise_id')->where('user_id', '=', $id)->get()->toArray();
        if(count($franchise_id) == 0 or $franchise_id[0]['franchise_id'] == 0){
            return $receptions = [];
        }
        $franchise_id = $franchise_id[0]['franchise_id'];
        $receptions = ReceptionModel::join('city_franchise_factory_reception_user', (function($join) use($franchise_id){
            $join->on('receptions.id', '=', 'city_franchise_factory_reception_user.reception_id')
                ->where([
                    ['city_franchise_factory_reception_user.franchise_id', '=', $franchise_id],
                    ['city_franchise_factory_reception_user.user_id', NULL],
                    ['receptions.deleted', '!=', '1']
                ]);
            }))
            ->select('receptions.id as id', 'receptions.name as name')
            ->get();

        return $receptions;
    }

    public function convert_receprion_data($data){
        $franchise_id = $data['franchise_id'];
        unset($data["_token"]);
        $city_data = CityFranchiseFactoryReceptionUserModel::get_city_data($franchise_id);
        $city_id = $city_data['city_id'];
        $utc = $city_data['utc'];

        $data['schedule_data'] = json_decode($data['schedule_data']);
        $day_time_array = ScheduleDayTimeModel::convert_schedule_data($data['schedule_data'], $utc);

        $creator_data = StaffModel::find(Auth::id())->toArray();
        $creator_id = $creator_data['id'];

        $coordinates = explode(', ' ,$data['rec_coords']);
        $date = Carbon::now()->toArray();
        $reception = [
            'name' => $data['additional_rec_address'],
            'address' => $data['rec_address'],
            'latitude' => $coordinates[0],
            'longitude' => $coordinates[1],
            'phone' => $data['rec_contacts'],
            'description' => $data['rec_description'],
            'created_at' => $date['formatted'],
            'updated_at' => $date['formatted'],
            'length' => $data['rec_length'],
            'width' => $data['rec_width'],
            'height' => $data['rec_height'],
            'weight' => $data['rec_weight'],
            'creator_id' => $creator_id,
            'household' => 0,
        ];
        if(isset($data['household_check'])){
            $reception['household'] = 1;
        }

        $last_reception_id = $this->insert_get_id($reception);

        $schedule_factory_reception = [
            'factory_id' => NULL,
            'reception_id' => $last_reception_id,
        ];

        $last_schedule_id = ScheduleFactoryReceptionModel::insert_get_id($schedule_factory_reception);
        ScheduleCompilationModel::collect_schedule_data($day_time_array, $last_schedule_id);

        $relationships = [
            'city_id' => $city_id,
            'franchise_id' => $franchise_id,
            'factory_id' => NULL,
            'reception_id' => $last_reception_id,
            'user_id' => NULL
        ];
        CityFranchiseFactoryReceptionUserModel::create($relationships);

    }

    public function users()
    {
        return $this->belongsToMany(StaffModel::class, 'user_reception','reception_id', 'user_id');
    }

}
