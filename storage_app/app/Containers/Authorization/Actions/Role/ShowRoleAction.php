<?php

namespace App\Containers\Authorization\Actions\Role;

use App\Abstracts\Action;
use App\Containers\Authorization\Models\Role;

/**
 * Class ShowRoleAction.
 *
 */
class ShowRoleAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return Role::with('permissions')->where('uuid', $request->uuid)->first();
    }
}
