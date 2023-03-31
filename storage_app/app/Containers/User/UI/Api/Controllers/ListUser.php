<?php

namespace App\Containers\User\UI\Api\Controllers;

use App\Containers\User\UI\Api\Requests\ListUserRequest;

use App\Containers\User\Actions\ListUserAction;


use App\Containers\User\UI\Api\Transformers\ListUserTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowUser.
 *
 */
class ListUser extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\ListUserRequest $request
     * @param \App\Containers\User\Actions\ListUserAction      $action
     *
     * @return Response
     */
    public function index(ListUserRequest $request, ListUserAction $action)
    {
        return $this->responseItem($action->run($request), new ListUserTransformer());
    }
    
}
