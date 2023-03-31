<?php

namespace App\Containers\Authorization\Traits;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;

trait SyncPermissionRoleTrait
{
    public static function syncPermissionRole()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) == 'user_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);

    }
}
