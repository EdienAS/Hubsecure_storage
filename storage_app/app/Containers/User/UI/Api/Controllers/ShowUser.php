<?php

namespace App\Containers\User\UI\Api\Controllers;

use App\Containers\User\UI\Api\Requests\ShowUserRequest;

use App\Containers\User\Actions\ShowUserAction;


use App\Containers\User\UI\Api\Transformers\UserTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowUser.
 *
 */
class ShowUser extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\ShowUserRequest $request
     * @param \App\Containers\User\Actions\ShowUserAction      $action
     *
     * @return Response
     */
    public function show(ShowUserRequest $request, ShowUserAction $action)
    {
        return $this->responseItem($action->run($request), new UserTransformer());
    }
    
}
