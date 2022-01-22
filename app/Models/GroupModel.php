<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasRolesAndPermissionsTrait;


class GroupModel extends Model
{
    protected $table='groups';
    use HasRolesAndPermissionsTrait;

    public function users()
    {
        return $this->hasMany(StaffModel::class, 'group_id');
    }

}
