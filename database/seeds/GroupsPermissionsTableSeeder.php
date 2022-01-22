<?php

use Illuminate\Database\Seeder;

class GroupsPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relationships = [
            [
                'group_id' => 1,
                'permission_id' => 1
            ],
            [
                'group_id' => 1,
                'permission_id' => 2
            ],
            [
                'group_id' => 1,
                'permission_id' => 3
            ],
            [
                'group_id' => 1,
                'permission_id' => 4
            ],
            [
                'group_id' => 1,
                'permission_id' => 5
            ],
            [
                'group_id' => 1,
                'permission_id' => 6
            ],
            [
                'group_id' => 1,
                'permission_id' => 7
            ],
            [
                'group_id' => 1,
                'permission_id' => 8
            ],
            [
                'group_id' => 1,
                'permission_id' => 9
            ],
            [
                'group_id' => 1,
                'permission_id' => 10
            ],
            [
                'group_id' => 2,
                'permission_id' => 1
            ],
            [
                'group_id' => 2,
                'permission_id' => 2
            ],
            [
                'group_id' => 2,
                'permission_id' => 3
            ],
            [
                'group_id' => 2,
                'permission_id' => 4
            ],
            [
                'group_id' => 2,
                'permission_id' => 5
            ],
            [
                'group_id' => 2,
                'permission_id' => 6
            ],
            [
                'group_id' => 2,
                'permission_id' => 7
            ],
            [
                'group_id' => 2,
                'permission_id' => 8
            ],
            [
                'group_id' => 3,
                'permission_id' => 1
            ],
            [
                'group_id' => 3,
                'permission_id' => 3
            ],
            [
                'group_id' => 3,
                'permission_id' => 4
            ],
            [
                'group_id' => 3,
                'permission_id' => 5
            ],
            [
                'group_id' => 3,
                'permission_id' => 6
            ],
            [
                'group_id' => 3,
                'permission_id' => 7
            ],
            [
                'group_id' => 3,
                'permission_id' => 8
            ],
            [
                'group_id' => 4,
                'permission_id' => 5
            ],
            [
                'group_id' => 5,
                'permission_id' => 5
            ],
            [
                'group_id' => 6,
                'permission_id' => 5
            ],
            [
                'group_id' => 7,
                'permission_id' => 5
            ],

        ];
        DB::table('groups_permissions')->insert($relationships);
    }
}
