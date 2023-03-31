<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use App\Containers\Teams\UI\Api\Requests\ListTeamInvitationRequest;

use App\Containers\Teams\Actions\ListTeamInvitationAction;


use App\Containers\Teams\UI\Api\Transformers\ListTeamInvitationTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListTeamInvitation.
 *
 */
class ListTeamInvitation extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\ListTeamInvitationRequest $request
     * @param \App\Containers\Teams\Actions\ListTeamInvitationAction      $action
     *
     * @return Response
     */
    public function index(ListTeamInvitationRequest $request, ListTeamInvitationAction $action)
    {
        return $this->responseItem($action->run($request), new ListTeamInvitationTransformer());
    }
    
}
