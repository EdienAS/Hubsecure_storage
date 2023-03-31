<?php

namespace App\Containers\User\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;

use App\Containers\User\Actions\DeleteUserAction;

use App\Containers\User\UI\Api\Requests\DeleteUserRequest;

/**
 * Class DestroyUser.
 *
 */
class DestroyUser extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\DeleteUserRequest $request
     * @param \App\Containers\User\Actions\DeleteUserAction          $action
     *
     * @return  Response
     */
    public function destroy(DeleteUserRequest $request, DeleteUserAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'User (' . $request->uuid . ') Deleted Successfully.',
        ]);
    }

    
}
