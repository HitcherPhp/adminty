<?php

namespace App\Models;

use App\Facades\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganisationsAttributeModel extends Model
{

    protected $table='organisations_attributes';
    public $timestamps = false;
    protected static $col_names = [
        [
            'text' => 'Наименование организации',
            'value' => 'organisation_name'
        ],
        [
            'text' => 'Должность руководителя',
            'value' => 'head_position'
        ],
        [
            'text' => 'Имя руководителя',
            'value' => 'head_name'
        ],
        [
            'text' => 'Количество заводов',
            'value' => 'factory_count'
        ],
        [
            'text' => 'Количество приемных пунктов',
            'value' => 'reception_count'
        ],
    ];

    public static function get_col_names(){
        return self::$col_names;
    }


    public static function get_first_franchises(){
        return 'first_franchises';
    }


    public function franchises(){
        return $this->belongsTo('App\Models\FranchiseModel', 'id', 'id');
    }

    public function get_model($attributes) {
        self::$model_attributes = $attributes;
        // self::$permissions = Permission::get_data_permissions();

        if (($attributes['data_for_removing'])) {
            $this->update_model($attributes);
        }

        if ($attributes['search_attribute']) {
            return $this->model_with_search($attributes);
        }

        else {
            $this->set_model();
        }

        return self::$response;
    }

    private function set_model(){
        if (self::$permissions == 'all') {

            self::$response['paginator'] = OrganisationsAttributeModel::select('id', 'fr_key', 'fr_value')
                ->where('fr_key', 'REQUISITE_ORG_NAME')
                ->paginate(self::$model_attributes['option']);

            $franchise['attributes'] = DB::table('franchises')
                ->select('franchises.id as id', 'org_attr.REQUISITE_ORG_NAME', 'org_attr.POSITION_HEAD', 'org_attr.SHORT_NAME_HEAD')
                ->leftJoin(DB::raw("(SELECT organisations_attributes.franchise_id,
                        MAX(CASE fr_key WHEN 'REQUISITE_ORG_NAME' THEN fr_value END) AS REQUISITE_ORG_NAME,
                        MAX(CASE fr_key WHEN 'POSITION_HEAD' THEN fr_value END) AS POSITION_HEAD,
                        MAX(CASE fr_key WHEN 'SHORT_NAME_HEAD' THEN fr_value END) AS SHORT_NAME_HEAD
                    FROM organisations_attributes
                    GROUP BY organisations_attributes.franchise_id
                ) as org_attr
                "), function($join){
                    $join->on('org_attr.franchise_id', '=', 'id');
                })
                // ->groupBy('id')
                ->get()
                ->toArray();

            $franchise['attributes'] = collect($franchise['attributes']);

            $franchise['spaces_count'] = FranchiseModel::leftJoin('user_franchise', 'franchises.id', '=', 'user_franchise.franchise_id')
                ->groupBy('franchises.id')
                ->select(
                    DB::raw('count(user_franchise.factory_id) as factory_count'),
                    DB::raw('count(user_franchise.reception_id) as reception_count'))
                ->get()->toArray();

            foreach ($franchise['attributes'] as $key => $value) {
                self::$response['franchise_data'][$key] = [
                    'id' => $value->id,
                    'REQUISITE_ORG_NAME' => $value->REQUISITE_ORG_NAME,
                    'POSITION_HEAD' => $value->POSITION_HEAD,
                    'SHORT_NAME_HEAD' => $value->SHORT_NAME_HEAD
                ];
                self::$response['franchise_data'][$key] = array_merge(self::$response['franchise_data'][$key], $franchise['spaces_count'][$key]);
            }
            // dd(self::$response);
        }
    }

    public function create($data){
        DB::table('organisations_attributes')->insert($data);
    }

    public function convert_franchise_attr_array($franchise_data){
        $userCollection = StaffModel::find(Auth::id());
        $creator_id = $userCollection['id'];

        $date = Carbon::now();
        $franchise = [
            'name' => $franchise_data['org_name'],
            'creator_id' => $creator_id,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted' => 0
        ];
        FranchiseModel::create($franchise);

        $new_franchises = FranchiseModel::where('created_at', $date)->get()->toArray();
        $franchise_id = $new_franchises[0]['id'];

        $city = CityModel::select('id', 'name')->where('id', $franchise_data['org_city_select'])->get()->toArray();
        $city_name = $city[0]['name'];

        // dd($city_name);


        /* Подготовка данных для добавления в organisations_attributes */
        $franchise_attr = [
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME',
                'fr_value' => $franchise_data['org_name'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'FULL_NAME_ORGANIZATION',
                'fr_value' => $franchise_data['full_org_name'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_PROPERTY_FORM',
                'fr_value' => $franchise_data['short_name_prop_form'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'POSITION_HEAD',
                'fr_value' => $franchise_data['pos_head'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_HEAD',
                'fr_value' => $franchise_data['name_head'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_NAME_FOR_DOC',
                'fr_value' => NULL,
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BANK',
                'fr_value' => $franchise_data['org_bank'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_BIC',
                'fr_value' => $franchise_data['org_bic'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_CA',
                'fr_value' => $franchise_data['org_ca'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_PA',
                'fr_value' => $franchise_data['org_pa'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INN',
                'fr_value' => $franchise_data['org_inn'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_COORDS',
                'fr_value' => $franchise_data['org_coords'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_KPP',
                'fr_value' => $franchise_data['org_kpp'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'BASIS_WHICH_PARTY_ACTING',
                'fr_value' => $franchise_data['regulation'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'SHORT_NAME_ACCOUNTANT',
                'fr_value' => $franchise_data['accountant_name'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_INDEX',
                'fr_value' => $franchise_data['org_index'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ADDRESS',
                'fr_value' => $franchise_data['org_index'].', г. '.$city_name.', '.$franchise_data['org_address'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'PHONE_NUMBER_INTERVIEW',
                'fr_value' => $franchise_data['phone_number_interview'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'REQUISITE_ORG_ONLY_ADDRESS',
                'fr_value' => $franchise_data['org_address'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'SITE_EMAIL',
                'fr_value' => $franchise_data['site_email'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'COURIER_EMAIL',
                'fr_value' => $franchise_data['courier_email'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_EMAIL',
                'fr_value' => $franchise_data['managers_email'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'COURIER_PHONE',
                'fr_value' => $franchise_data['courier_phone'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'MANAGERS_PHONE',
                'fr_value' => $franchise_data['managers_phone'],
            ],
            [
                'franchise_id' => $franchise_id,
                'customer_id' => NULL,
                'fr_key' => 'OPERATOR_PHONE',
                'fr_value' => $franchise_data['operator_phone'],
            ],
        ];

        $this->create($franchise_attr);


        /* Подготовка данных для добавления в city_franchise_factory_reception_user */
        $relations_table = [
            'city_id' => $franchise_data['org_city_select'],
            'franchise_id' => $franchise_id,
            'factory_id' => NULL,
            'reception_id' => NULL,
            'user_id' => NULL,
        ];

        CityFranchiseFactoryReceptionUserModel::create($relations_table);
    }

}
