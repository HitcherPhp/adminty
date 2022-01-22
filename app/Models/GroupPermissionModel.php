<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GroupPermissionModel extends Model
{
    protected $table='groups_permissions';

    public static function permissions() {
        return GroupPermissionModel::join('permissions', 'groups_permissions.permission_id', '=', 'permissions.id')
            ->select('permissions.name as permission_name')
            ->where('groups_permissions.group_id', '=', Auth::user()->group_id)
            ->get()->toArray();
    }

}
