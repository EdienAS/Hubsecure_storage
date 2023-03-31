<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Permission;

use App\Containers\Authorization\UI\Api\Requests\Permission\ListPermissionRequest;

use App\Containers\Authorization\Actions\Permission\ListPermissionAction;

use App\Containers\Authorization\UI\Api\Transformers\Permission\ListPermissionTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListPermission.
 *
 */
class ListPermission extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Permission\ListPermissionRequest $request
     * @param \App\Containers\Authorization\Actions\Permission\ListPermissionAction      $action
     *
     * @return Response
     */
    public function index(ListPermissionRequest $request, ListPermissionAction $action)
    {
        return $this->responseItem($action->run($request), new ListPermissionTransformer());
    }
    
}
