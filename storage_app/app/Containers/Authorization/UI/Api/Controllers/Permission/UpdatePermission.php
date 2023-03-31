<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Permission;

 use App\Containers\Authorization\UI\Api\Requests\Permission\UpdatePermissionRequest;

 use App\Containers\Authorization\Actions\Permission\UpdatePermissionAction;

use App\Containers\Authorization\UI\Api\Transformers\Permission\PermissionTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdatePermission.
 *
 */
class UpdatePermission extends ControllerApi
{

    
    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Permission\UpdatePermissionRequest $request
     * @param \App\Containers\Authorization\Actions\Permission\UpdatePermissionAction          $action
     *
     * @return  Response
     */
    public function update(UpdatePermissionRequest $request, UpdatePermissionAction $action)
    {
        return $this->responseItem($action->run($request), new PermissionTransformer());
    }
    
}
