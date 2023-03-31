<?php

namespace App\Containers\UserSettings\Actions;

use App\Abstracts\Action;
use App\Containers\User\Models\User;
use App\Containers\UserSettings\Models\Usersetting;

/**
 * Class ShowUserSettingsAction.
 *
 */
class ShowUserSettingsAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $user = User::where('uuid', $request->uuid)->first();
        
        return Usersetting::where('user_id', $user->id)->first();
    }
}
