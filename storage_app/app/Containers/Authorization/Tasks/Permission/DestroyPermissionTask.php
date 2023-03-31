<?php

namespace App\Containers\Authorization\Tasks\Permission;

use App\Abstracts\Task;
use App\Containers\Authorization\Models\Permission;

/**
 * Class DestroyPermissionTask.
 *
 */
class DestroyPermissionTask extends Task
{

    /**
     * @param $uuid
     *
     * @return bool
     */
    public function run($uuid)
    {
        // delete the record from the users table.
        $permission = Permission::where('uuid', $uuid)->first();
        
        $permission->delete();

        return true;
    }
}
