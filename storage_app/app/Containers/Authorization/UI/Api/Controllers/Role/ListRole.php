<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Role;

use App\Containers\Authorization\UI\Api\Requests\Role\ListRoleRequest;

use App\Containers\Authorization\Actions\Role\ListRoleAction;

use App\Containers\Authorization\UI\Api\Transformers\Role\ListRoleTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListRole.
 *
 */
class ListRole extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Role\ListRoleRequest $request
     * @param \App\Containers\Authorization\Actions\Role\ListRoleAction      $action
     *
     * @return Response
     */
    public function index(ListRoleRequest $request, ListRoleAction $action)
    {
        return $this->responseItem($action->run($request), new ListRoleTransformer());
    }
    
}
