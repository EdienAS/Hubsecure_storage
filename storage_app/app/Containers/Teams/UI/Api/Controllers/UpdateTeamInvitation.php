<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Teams\Actions\UpdateTeamInvitationAction;
use App\Containers\Teams\UI\Api\Requests\UpdateTeamInvitationRequest;
use App\Containers\Teams\UI\Api\Transformers\TeamInvitationTransformer;

/**
 * Class UpdateTeamInvitation.
 *
 */
class UpdateTeamInvitation extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\UpdateTeamInvitationRequest $request
     * @param \App\Containers\Teams\Actions\UpdateTeamInvitationAction      $action
     *
     * @return Response
     */
    public function update(UpdateTeamInvitationRequest $request, UpdateTeamInvitationAction $action)
    {
        return $this->responseItem($action->run($request), new TeamInvitationTransformer());
    }
    
}
