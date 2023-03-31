<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use App\Containers\Teams\UI\Api\Requests\UpdateTeamFolderRequest;

 use App\Containers\Teams\Actions\UpdateTeamFolderAction;


use App\Containers\Teams\UI\Api\Transformers\TeamFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateTeamFolder.
 *
 */
class UpdateTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\UpdateTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\UpdateTeamFolderAction        $action
     *
     * @return  Response
     */
    public function update(UpdateTeamFolderRequest $request, UpdateTeamFolderAction $action)
    {
        
        // Updated team folder
        return $this->responseItem($action->run($request), new TeamFolderTransformer());
    }

}
