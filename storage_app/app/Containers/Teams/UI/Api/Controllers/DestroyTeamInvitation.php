<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Teams\Actions\DestroyTeamInvitationAction;
use App\Containers\Teams\UI\Api\Requests\DestroyTeamInvitationRequest;


/**
 * Class DestroyTeamInvitation.
 *
 */
class DestroyTeamInvitation extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\DestroyTeamInvitationRequest $request
     * @param \App\Containers\Teams\Actions\DestroyTeamInvitationAction        $action
     *
     * @return  Response
     */
    public function destroy(DestroyTeamInvitationRequest $request, DestroyTeamInvitationAction $action)
    {
        
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Team Invitation (' . $request->uuid . ') Distroyed Successfully.',
        ]);
    }

}
