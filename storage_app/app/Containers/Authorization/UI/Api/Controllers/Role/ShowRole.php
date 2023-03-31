<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Role;

use App\Containers\Authorization\UI\Api\Requests\Role\ShowRoleRequest;

use App\Containers\Authorization\Actions\Role\ShowRoleAction;


use App\Containers\Authorization\UI\Api\Transformers\Role\ShowRoleTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowRole.
 *
 */
class ShowRole extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\ShowRoleRequest $request
     * @param \App\Containers\Authorization\Actions\Role\ShowRoleAction      $action
     *
     * @return Response
     */
    public function show(ShowRoleRequest $request, ShowRoleAction $action)
    {
        return $this->responseItem($action->run($request), new ShowRoleTransformer());
    }
    
}
