<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Role;

 use App\Containers\Authorization\UI\Api\Requests\Role\UpdateRoleRequest;

 use App\Containers\Authorization\Actions\Role\UpdateRoleAction;


use App\Containers\Authorization\UI\Api\Transformers\Role\RoleTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateRole.
 *
 */
class UpdateRole extends ControllerApi
{

    
    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Role\UpdateRoleRequest $request
     * @param \App\Containers\Authorization\Actions\Role\UpdateRoleAction          $action
     *
     * @return  Response
     */
    public function update(UpdateRoleRequest $request, UpdateRoleAction $action)
    {
        return $this->responseItem($action->run($request), new RoleTransformer());
    }
    
}
