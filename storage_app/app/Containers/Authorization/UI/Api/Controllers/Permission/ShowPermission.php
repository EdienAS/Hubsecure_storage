<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Permission;

use Response;
use App\Abstracts\ControllerApi;

use App\Containers\Authorization\Actions\Permission\ShowPermissionAction;

use App\Containers\Authorization\UI\Api\Requests\Permission\ShowPermissionRequest;

use App\Containers\Authorization\UI\Api\Transformers\Permission\ShowPermissionTransformer;

/**
 * Class ShowPermission.
 *
 */
class ShowPermission extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Permission\ShowPermissionRequest $request
     * @param \App\Containers\Authorization\Actions\Permission\ShowPermissionAction      $action
     *
     * @return Response
     */
    public function show(ShowPermissionRequest $request, ShowPermissionAction $action)
    {
        return $this->responseItem($action->run($request), new ShowPermissionTransformer());
    }
    
}
