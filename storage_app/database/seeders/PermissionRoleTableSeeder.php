<?php

namespace Database\Seeders;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use Illuminate\Database\Seeder;
use App\Containers\Authorization\Traits\SyncPermissionRoleTrait;

class PermissionRoleTableSeeder extends Seeder
{
    use SyncPermissionRoleTrait;
    
    public function run()
    {
        $this->syncPermissionRole();
    }
}
