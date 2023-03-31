<?php

namespace App\Containers\Authorization\Tasks\Role;

use App\Containers\Authorization\Models\Role;
use App\Abstracts\Action;

/**
 * Class DestroyRoleTask.
 *
 */
class DestroyRoleTask extends Action
{

    /**
     * @param $uuid
     *
     * @return bool
     */
    public function run($uuid)
    {
        // delete the record from the users table.
        $role = Role::where('uuid', $uuid)->first();
        

        $role->delete();

        return true;
    }
}
