<?php

namespace App\Containers\User\Actions;

use App\Abstracts\Action;
use App\Containers\User\Resources\UserResource;

/**
 * Class ShowUserAction.
 *
 */
class ShowUserAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return array(new UserResource(auth()->user()));
    }
}
