<?php

namespace App\Models;

use App\Facades\Permission;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Facades\Message;
use Illuminate\Support\Facades\Log;
use App\Traits\TableTrait;

class StaffModel extends Authenticatable
{
    protected $table='staff';
    use Notifiable, TableTrait;


    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $col_names = [
        [
            'text' => 'Имя',
            'value' => 'name'
        ],
        [
            'text' => 'Телефон',
            'value' => 'staff_phone'
        ],
        [
            'text' => 'Почта',
            'value' => 'staff_email'
        ],
        [
            'text' => 'Группа',
            'value' => 'staff_group'
        ]

    ];


    public static function get_col_names(){
        return self::$col_names;
    }

    public function insert_get_id($data) {
        $last_staff_id = DB::table('staff')->insertGetId($data);
        return $last_staff_id;
    }


    private static $attr;

    public function get_model($attr) {
        self::$attr = &$attr;

        if ($attr['data_for_removing'] or $attr['delete_all']) {
            $query = $this->new_query();
            $this->set_update_attr($query, $attr['delete_all'], $attr['data_for_removing']);
            if ($attr['search_attribute']) {
                $this->set_search_attr($query, $attr['search_attribute']);
            }
            self::$response['updated'] = $query->update(['factories.deleted' => true]);
        }

        $query = $this->new_query();
        $this->set_select_attr($query);
        $this->set_where_attr($query);
        if ($attr['search_attribute']) {
            $this->set_search_attr($query, $attr['search_attribute']);
        }
        $this->set_order_attr($query);
        // self::$response['model'] = $query->paginate($attr['option']);

        return self::$response;

    }

    private function new_query(){
        return StaffModel::join('groups', 'users.group_id', '=', 'groups.id')
            ->join('city_franchise_factory_reception_user.city_id', '=', 'cities.id')
            ->join('franchises', 'city_franchise_factory_reception_user.franchise_id', '=', 'franchises.id');
    }

    private function set_select_attr(&$query) {
        $query->select('factories.id as id',
            'franchises.name as name',
            DB::raw("CONCAT(cities.name, ', ', factories.address) as address"),
            DB::raw("IFNULL(factories.name, 'нет') as address_name"),
            'factories.phone as phone'
        );
    }

    private function set_where_attr(&$query) {
        if (self::$permissions == 'all') {
            $user_id = Auth::id();
            $group_id = Auth::user()->group_id;
            $f_id = SelectFranchiseModel::get_franchise('id');

            $query
                ->whereNull('city_franchise_factory_reception_user.user_id')
                ->whereNotNull('city_franchise_factory_reception_user.factory_id')
                ->whereNull('city_franchise_factory_reception_user.reception_id')
                ->where('factories.deleted', '=', false);
            if ($f_id != 0 or !empty($f_id)) {
                $query->where('city_franchise_factory_reception_user.franchise_id', '=', $f_id);
            }
            else {
                if ($group_id == 1) {
                    $query->whereNotNull('city_franchise_factory_reception_user.franchise_id');
                }
                else if ($group_id == 2) {
                    $query->whereIn('city_franchise_factory_reception_user.franchise_id', function($q) use ($user_id) {
                        $q->select('city_franchise_factory_reception_user.franchise_id')
                            ->from(with('city_franchise_factory_reception_user'))
                            ->where('city_franchise_factory_reception_user.user_id', $user_id);
                    });
                }
            }
        }
    }

    private function set_search_attr(&$query, &$search_attribute) {
        $query->where(function ($q) use ($search_attribute) {
            $q->where('franchises.name', 'like', '%' . $search_attribute . '%')
                ->orWhere(DB::raw("CONCAT(cities.name, ', ', factories.address)"), 'like', '%' . $search_attribute . '%')
                ->orWhere('factories.name', 'like', '%' . $search_attribute . '%')
                ->orWhere('factories.phone', 'like', '%' . $search_attribute . '%');
        });
    }

    private function set_order_attr(&$query) {
        $query->orderByDesc('factories.created_at');
    }

    private function set_update_attr(&$query, &$delete_all, &$data_for_removing) {
        if ($delete_all) {
            $query->where('factories.deleted', '=', false);
        }
        else {
            $query->whereIn('factories.id', $data_for_removing);
        }
    }

    public function convert_staff_data($data){
        $franchise_id = $data['franchise_id'];
        $data['conv_name'] = $data['surname'].' '.$data['name'].' '.$data['patronymic'];
        unset($data["_token"], $data['surname'], $data['name'], $data['patronymic']);
        $data['password'] = Str::random(10);
        $data['remember_token'] = Str::random(10);

        $date = Carbon::now()->toArray();
        $staff_data = [
            'name' => $data['conv_name'],
            'phone' => $data['staff_phone'],
            'email' => $data['staff_email'],
            'password' => Hash::make($data['password']),
            'remember_token' => $data['remember_token'],
            'created_at' => $date['formatted'],
            'updated_at' => $date['formatted'],
            'group_id' => $data['group']
        ];

        $last_staff_id = $this->insert_get_id($staff_data);

        $city_id = CityFranchiseFactoryReceptionUserModel::select('city_id')->where(function($query) use($franchise_id){
            $query->where('franchise_id', $franchise_id)
                ->where('factory_id', NULL)
                ->where('reception_id', NULL)
                ->where('user_id', NULL);
        })
        ->get()->toArray();

        $city_id = $city_id[0]['city_id'];

        if(!isset($data['staff_reception_select'])){
            $relationships = [
                'city_id' => $city_id,
                'franchise_id' => $franchise_id,
                'factory_id' => NULL,
                'reception_id' => NULL,
                'user_id' => $last_staff_id
            ];
        }else{
            $relationships = [
                'city_id' => $city_id,
                'franchise_id' => $franchise_id,
                'factory_id' => NULL,
                'reception_id' => $data['staff_reception_select'],
                'user_id' => $last_staff_id
            ];
        }
        CityFranchiseFactoryReceptionUserModel::create($relationships);
        return $data;
    }

    public static function get_staff_table($data){

        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $user_data = Auth::user();

        $where = [
            ['s.deleted', '=', 0],
            ['s.id', '<>', $user_data->id],
        ];

        $query = DB::table('staff as s')
            ->join('groups as g', 's.group_id', '=', 'g.id')
            ->join('city_franchise_factory_reception_user as cffru', 's.id', '=', 'cffru.user_id')
            ->select(
                's.id',
                's.name',
                's.phone as staff_phone',
                's.email as staff_email',
                'g.name as staff_group'
            )
            ->orderBy('s.id');

        $const = Permission::ALL_STAFF_TABLE_VIEW;
        # используется TableTrait
        return self::get_table($query, $where, $data, $const, $user_data);



        // return compact_staff_table_data($response);

    }


    public static function compact_staff_table_data($response){

        // $first_staff = self::get_staff_table([]);
        //
        // if (Message::NOT_FOUND === $first_staff) {
        //     return $first_staff;
        // }else if(Message::SERVER_ERROR === $first_staff){
        //     return $first_staff;
        // }
        $headers = ['headers' => self::get_col_names()];
        $data = array_merge($headers, ['table' => $response]);

        return $data;
    }

    public static function get_staff_member_data($id){
        try {
            $certain_staff_member = DB::table('staff as s')->join('groups as g', 's.group_id', '=', 'g.id')
                ->select(
                    's.id',
                    's.name',
                    's.phone as staff_phone',
                    's.email as staff_email',
                    'g.name as group'
                    )
                ->where('s.id', '=', $id)
                ->get()
                ->toArray();

            if(empty($certain_staff_member)){
                return Message::NOT_FOUND;
            }
            return $certain_staff_member;

        } catch (\Exception $e) {
            Log::channel('db_fail')->info($e);
            return Message::SERVER_ERROR;
        }

    }











    public function group()
    {
        return $this->belongsTo(GroupModel::class);
    }


}
