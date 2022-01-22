<?php

namespace App\Models;

use App\Facades\Message;
use App\Facades\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Facades\Error;
use App\Traits\TableTrait;


class FactoryModel extends Model
{
    use TableTrait;
    protected $table='factories';
    protected static $col_names = [
        [
            'text' => 'Имя завода',
            'value' => 'factory_name'
        ],
        [
            'text' => 'Франшиза',
            'value' => 'franchise_name'
        ],
        [
            'text' => 'Адрес',
            'value' => 'factory_address'
        ],
        [
            'text' => 'Квартира/офис',
            'value' => 'factory_flat_office'
        ],
        [
            'text' => 'Контакты',
            'value' => 'factory_contacts'
        ],
    ];

    /*
    *   массив приходящий в метод create должен выглядеть следующим образом:
    *   $data = [
    *       'column_name' => $data['cell_data'],
    *       'column_name' => $data['cell_data'],
    *            ...      =>        ...
    *       'column_name' => $data['cell_data'],
    *   ]
    *
    */
    public function insert_get_id($data) {
        $last_factory_id = DB::table('factories')->insertGetId($data);
        return $last_factory_id;
    }

    public static function get_factories_table($data){

        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $user_data = Auth::user();

        $where = [
            ['f.deleted', '=', 0],
            // ['s.id', '<>', $user_data->id],
        ];

        $query = DB::table('factories as f')->join('addresses as adrs', 'f.address_id', '=', 'adrs.id')
            ->join('city_franchise_factory_reception_user as cffru', 'f.id', '=', 'cffru.factory_id')
            ->join('franchises as fr', 'cffru.franchise_id', '=', 'fr.id')
            ->select(
                'f.id',
                'fr.name as franchise_name',
                'fr.id as franchise_id',
                'adrs.name as factory_name',
                'adrs.address as factory_address',
                'adrs.flat/office as factory_flat_office',
                'f.phone as factory_contacts'
            )
            ->orderBy('franchise_id');

        $const = Permission::ALL_FACTORIES_TABLE_VIEW;

        # используется TableTrait
        return self::get_table($query, $where, $data, $const, $user_data);


    }


    public static function check_before_send_first_factories(){
        $headers = ['headers' => FactoryModel::get_col_names()];

        $first_factories = self::get_first_factories();

        if (Message::NOT_FOUND === $first_factories) {
            return $first_factories;
        }else if(Message::SERVER_ERROR === $first_factories){
            return $first_factories;
        }

        $data = array_merge($headers, ['table' => $first_factories]);

        return $data;

    }

    public function convert_factory_data($data){

        $franchise_id = $data['franchise_id'];
        $city_data = CityFranchiseFactoryReceptionUserModel::get_city_data($franchise_id);
        $city_id = $city_data['city_id'];
        $utc = $city_data['utc'];


        $data['schedule_data'] = json_decode($data['schedule_data']);
        $day_time_array = ScheduleDayTimeModel::convert_schedule_data($data['schedule_data'], $utc);

        $coordinates = explode(', ' ,$data['fact_coords']);
        $creator_data = StaffModel::find(Auth::id())->toArray();
        $creator_id = $creator_data['id'];

        $franchise_id = $data['franchise_id'];
        unset($data["_token"]);


        $date = Carbon::now()->toArray();
        $factory = [
            'name' => $data['additional_fact_address'],
            'address' => $data['fact_address'],
            'latitude' => $coordinates[0],
            'longitude' => $coordinates[1],
            'phone' => $data['fact_contacts'],
            'description' => $data['fact_description'],
            'created_at' => $date['formatted'],
            'updated_at' => $date['formatted'],
            'creator_id' => $creator_id,
        ];

        $last_factory_id = $this->insert_get_id($factory);

        $schedule_factory_reception = [
            'factory_id' => $last_factory_id,
            'reception_id' => NULL,
        ];

        $last_schedule_id = ScheduleFactoryReceptionModel::insert_get_id($schedule_factory_reception);
        ScheduleCompilationModel::collect_schedule_data($day_time_array, $last_schedule_id);

        $relationships = [
            'city_id' => $city_id,
            'franchise_id' => $franchise_id,
            'factory_id' => $last_factory_id,
            'reception_id' => NULL,
            'user_id' => NULL
        ];

        CityFranchiseFactoryReceptionUserModel::create($relationships);

    }


    public static function get_col_names(){
        return self::$col_names;
    }

    public static function get_factory_data($id){
        try {
            // $certain_factory = DB::table('staff as s')->join('groups as g', 's.group_id', '=', 'g.id')
            //     ->select(
            //         's.id',
            //         's.name',
            //         's.phone as staff_phone',
            //         's.email as staff_email',
            //         'g.name as group'
            //         )
            //     ->where('s.id', '=', $id)
            //     ->get()
            //     ->toArray();
            $certain_factory = ['certain_factory'];
            if(empty($certain_factory)){
                return Message::NOT_FOUND;
            }
            return $certain_factory;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }
    }


    public function users()
    {
        return $this->belongsToMany(StaffModel::class,'city_franchise_factory_reception_user','factory_id', 'user_id');
    }



}
