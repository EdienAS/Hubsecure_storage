<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Teams\Actions\ShowTeamInvitationAction;
use App\Containers\Teams\UI\Api\Requests\ShowTeamInvitationRequest;
use App\Containers\Teams\UI\Api\Transformers\TeamInvitationTransformer;

/**
 * Class ShowTeamInvitation.
 *
 */
class ShowTeamInvitation extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\ShowTeamInvitationRequest $request
     * @param \App\Containers\Teams\Actions\ShowTeamInvitationAction      $action
     *
     * @return Response
     */
    public function show(ShowTeamInvitationRequest $request, ShowTeamInvitationAction $action)
    {
        return $this->responseItem($action->run($request), new TeamInvitationTransformer());
    }
    
}
