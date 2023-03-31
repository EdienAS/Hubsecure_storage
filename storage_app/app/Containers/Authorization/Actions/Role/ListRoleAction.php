<?php

namespace App\Containers\Authorization\Actions\Role;

use App\Abstracts\Action;
use App\Containers\Authorization\Models\Role;

/**
 * Class ListRoleAction.
 *
 */
class ListRoleAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        return Role::with('permissions')->get();
    }
}
