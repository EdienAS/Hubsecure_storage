<?php

namespace App\Containers\Authorization\Actions\Permission;

use App\Abstracts\Action;
use App\Containers\Authorization\Models\Permission;

/**
 * Class ListPermissionAction.
 *
 */
class ListPermissionAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        return Permission::with('roles')->get();
    }
}
