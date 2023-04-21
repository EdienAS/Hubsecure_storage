<?php

namespace App\Containers\UserSettings\UI\Api\Controllers;

use App\Containers\UserSettings\UI\Api\Requests\GetUserAvatarRequest;

use App\Containers\UserSettings\Actions\GetUserAvatarAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class GetUserAvatar.
 *
 */
class GetUserAvatar extends ControllerApi
{

    /**
     * @param \App\Containers\UserSettings\UI\Api\Requests\GetUserAvatarRequest $request
     * @param \App\Containers\UserSettings\Actions\GetUserAvatarAction      $action
     *
     * @return Response
     */
    public function get(GetUserAvatarRequest $request, GetUserAvatarAction $action)
    {
        return $action->run($request);
    }
    
}
