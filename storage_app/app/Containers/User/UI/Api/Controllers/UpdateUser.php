<?php

namespace App\Containers\User\UI\Api\Controllers;

use App\Containers\User\UI\Api\Requests\UpdateUserRequest;

use App\Containers\User\Actions\UpdateUserAction;

use App\Containers\User\UI\Api\Transformers\UserTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateUser.
 *
 */
class UpdateUser extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\UpdateUserRequest $request
     * @param \App\Containers\User\Actions\UpdateUserAction          $action
     *
     * @return  Response
     */
    public function update(UpdateUserRequest $request, UpdateUserAction $action)
    {
        return $this->responseItem($action->run($request), new UserTransformer());
    }
}
