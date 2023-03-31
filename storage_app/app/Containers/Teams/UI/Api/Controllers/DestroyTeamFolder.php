<?php

namespace App\Containers\Teams\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Teams\Actions\DestroyTeamFolderAction;
use App\Containers\Teams\UI\Api\Requests\DestroyTeamFolderRequest;


/**
 * Class DestroyTeamFolder.
 *
 */
class DestroyTeamFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\DestroyTeamFolderRequest $request
     * @param \App\Containers\Teams\Actions\DestroyTeamFolderAction        $action
     *
     * @return  Response
     */
    public function destroy(DestroyTeamFolderRequest $request, DestroyTeamFolderAction $action)
    {
        
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Team for folder (' . $request->uuid . ') Dissolved Successfully.',
        ]);
    }

}
