<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
 use App\Containers\Teams\Actions\ConvertTeamFolderAction;
use App\Containers\Teams\UI\Api\Requests\ConvertTeamFolderRequest;

/**
 * Class ConvertTeamFolder.
 *
 */
class ConvertTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\ConvertTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\ConvertTeamFolderAction        $action
     *
     * @return  Response
     */
    public function convert(ConvertTeamFolderRequest $request, ConvertTeamFolderAction $action)
    {
        // Convert to team folder
        $action->run($request);
        return $this->responseNoContent([
            'message' => 'Folder converted to team folder successfully.'
        ]);
    }

}
