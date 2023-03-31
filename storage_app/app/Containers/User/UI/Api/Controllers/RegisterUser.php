<?php

namespace App\Containers\User\UI\Api\Controllers;

use App\Containers\User\UI\Api\Requests\CreateUserRequest;

use App\Containers\User\Actions\CreateUserAction;

use App\Containers\User\UI\Api\Transformers\UserFullTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class RegisterUser.
 *
 */
class RegisterUser extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\CreateUserRequest $request
     * @param \App\Containers\User\Actions\CreateUserAction        $action
     *
     * @return  Response
     */
    public function create(CreateUserRequest $request, CreateUserAction $action)
    {
        // create and login (true parameter) the new user
        return $this->responseItem($action->run($request, true), new UserFullTransformer());
    }
}
