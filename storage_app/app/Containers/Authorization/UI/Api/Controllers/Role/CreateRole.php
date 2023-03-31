<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Role;

use App\Containers\Authorization\UI\Api\Requests\Role\CreateRoleRequest;

 use App\Containers\Authorization\Actions\Role\CreateRoleAction;


use App\Containers\Authorization\UI\Api\Transformers\Role\RoleTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class CreateRole.
 *
 */
class CreateRole extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Role\CreateRoleRequest $request
     * @param \App\Containers\Authorization\Actions\Role\CreateRoleAction        $action
     *
     * @return  Response
     */
    public function create(CreateRoleRequest $request, CreateRoleAction $action)
    {
        
        // create (true parameter) the new role
        return $this->responseItem($action->run($request, true), new RoleTransformer());
    }

}
