<?php

namespace App\Containers\Authentication\UI\Api\Controllers;

use App\Abstracts\ControllerApi;

use App\Containers\Authentication\UI\Api\Requests\LogoutRequest;

use App\Containers\Authentication\Actions\ApiLogoutAction;

/**
 * Class Controller.
 *
 */
class AuthLogout extends ControllerApi
{
        
    /**
     * @param \App\Containers\Authentication\UI\Api\Requests\LogoutRequest $request
     * @param \App\Containers\Authentication\Actions\ApiLogoutAction       $action
     *
     * @return \Dingo\Api\Http\Response
     */
    public function logout(LogoutRequest $request, ApiLogoutAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'User Logged Out Successfully.',
        ]);
    }
}
