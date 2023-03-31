<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Permission;

use App\Containers\Authorization\UI\Api\Requests\Permission\CreatePermissionRequest;

 use App\Containers\Authorization\Actions\Permission\CreatePermissionAction;


use App\Containers\Authorization\UI\Api\Transformers\Permission\PermissionTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class CreatePermission.
 *
 */
class CreatePermission extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Permission\CreatePermissionRequest $request
     * @param \App\Containers\Authorization\Actions\Permission\CreatePermissionAction        $action
     *
     * @return  Response
     */
    public function create(CreatePermissionRequest $request, CreatePermissionAction $action)
    {
        
        // create (true parameter) the new permission
        return $this->responseItem($action->run($request, true), new PermissionTransformer());
    }

}
