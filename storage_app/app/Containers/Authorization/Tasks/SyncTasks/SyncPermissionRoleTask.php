<?php

namespace App\Containers\Authorization\Tasks\SyncTasks;


use App\Abstracts\Task;
use App\Containers\Authorization\Traits\SyncPermissionRoleTrait;

class SyncPermissionRoleTask extends Task
{
    use SyncPermissionRoleTrait;
    
    public function run()
    {
        return $this->syncPermissionRole();
    }
}
