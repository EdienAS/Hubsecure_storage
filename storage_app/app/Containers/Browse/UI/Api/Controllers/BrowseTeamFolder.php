<?php

namespace App\Containers\Browse\UI\Api\Controllers;

use App\Containers\Browse\UI\Api\Requests\BrowseTeamFolderRequest;

use App\Containers\Browse\Actions\BrowseTeamFolderAction;


use App\Containers\Browse\UI\Api\Transformers\BrowseTeamFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class BrowseTeamFolder.
 *
 */
class BrowseTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\BrowseTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\BrowseTeamFolderAction      $action
     *
     * @return Response
     */
    public function get(BrowseTeamFolderRequest $request, BrowseTeamFolderAction $action)
    {
        return $this->responseItem($action->run($request->uuid), new BrowseTeamFolderTransformer());
    }
    
}
