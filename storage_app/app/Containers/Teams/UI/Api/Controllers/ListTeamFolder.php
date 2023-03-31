<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use App\Containers\Teams\UI\Api\Requests\ListTeamFolderRequest;

use App\Containers\Teams\Actions\ListTeamFolderAction;


use App\Containers\Teams\UI\Api\Transformers\ListTeamFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListTeamFolder.
 *
 */
class ListTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\ListTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\ListTeamFolderAction      $action
     *
     * @return Response
     */
    public function index(ListTeamFolderRequest $request, ListTeamFolderAction $action)
    {
        return $this->responseItem($action->run($request), new ListTeamFolderTransformer());
    }
    
}
