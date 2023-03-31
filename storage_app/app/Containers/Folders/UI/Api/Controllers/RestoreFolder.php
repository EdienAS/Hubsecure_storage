<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\RestoreFolderRequest;

use App\Containers\Folders\Actions\RestoreFolderAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class RestoreFolder.
 *
 */
class RestoreFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\RestoreFolderRequest $request
     * @param \App\Containers\Folders\Actions\RestoreFolderAction          $action
     *
     * @return  Response
     */
    public function restore(RestoreFolderRequest $request, RestoreFolderAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Folder (' . $request->uuid . ') Restored Successfully.',
        ]);
    }

    
}
