<?php

namespace App\Containers\Authorization\Actions\Permission;

use App\Abstracts\Action;
use App\Containers\Authorization\Models\Permission;

/**
 * Class ShowPermissionAction.
 *
 */
class ShowPermissionAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return Permission::with('roles')->where('uuid', $request->uuid)->first();
    }
}
