<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use App\Containers\Teams\UI\Api\Requests\CreateTeamFolderRequest;

 use App\Containers\Teams\Actions\CreateTeamFolderAction;


use App\Containers\Teams\UI\Api\Transformers\TeamFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class CreateTeamFolder.
 *
 */
class CreateTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\CreateFolderRequest $request
     * @param \App\Containers\Teams\Actions\CreateFolderAction        $action
     *
     * @return  Response
     */
    public function store(CreateTeamFolderRequest $request, CreateTeamFolderAction $action)
    {
        
        // create new folder
        return $this->responseItem($action->run($request), new TeamFolderTransformer());
    }

}
