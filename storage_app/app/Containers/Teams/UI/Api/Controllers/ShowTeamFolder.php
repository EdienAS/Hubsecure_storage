<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use App\Containers\Teams\UI\Api\Requests\ShowTeamFolderRequest;

use App\Containers\Teams\Actions\ShowTeamFolderAction;


use App\Containers\Teams\UI\Api\Transformers\TeamFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowTeamFolder.
 *
 */
class ShowTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\ShowTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\ShowTeamFolderAction      $action
     *
     * @return Response
     */
    public function show(ShowTeamFolderRequest $request, ShowTeamFolderAction $action)
    {
        return $this->responseItem($action->run($request), new TeamFolderTransformer());
    }
    
}
