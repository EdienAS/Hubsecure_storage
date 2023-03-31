<?php

namespace App\Containers\Authentication\UI\Api\Controllers;

use App\Abstracts\ControllerApi;

use App\Containers\Authentication\UI\Api\Requests\LoginRequest;

use App\Containers\Authentication\Actions\ApiLoginAction;

use App\Containers\User\UI\Api\Transformers\UserFullTransformer;

/**
 * Class AuthLogin.
 *
 */
class AuthLogin extends ControllerApi
{
    /**
     * @param \App\Containers\Authentication\UI\Api\Requests\LoginRequest $request
     * @param \App\Containers\Authentication\Actions\ApiLoginAction       $action
     *
     * @return \Dingo\Api\Http\Response
     */
    public function login(LoginRequest $request, ApiLoginAction $action)
    {
        $user = $action->run($request['email'], $request['password']);

        return $this->responseItem($user, new UserFullTransformer());
    }

}
