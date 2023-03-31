<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
 use App\Containers\Teams\Actions\LeaveTeamFolderAction;
use App\Containers\Teams\UI\Api\Requests\LeaveTeamFolderRequest;

/**
 * Class LeaveTeamFolder.
 *
 */
class LeaveTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\LeaveTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\LeaveTeamFolderAction        $action
     *
     * @return  Response
     */
    public function leave(LeaveTeamFolderRequest $request, LeaveTeamFolderAction $action)
    {
        // Leave team folder
        $action->run($request);
        return $this->responseNoContent([
            'message' => 'You left team folder (' . $request->uuid . ') successfully.'
        ]);
    }

}
