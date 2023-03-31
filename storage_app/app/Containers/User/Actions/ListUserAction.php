<?php

namespace App\Containers\User\Actions;

use App\Abstracts\Action;
use App\Containers\User\Models\User;

/**
 * Class ListUserAction.
 *
 */
class ListUserAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        return User::with('role')->get();
    }
}
