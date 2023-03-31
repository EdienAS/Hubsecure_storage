<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\RestoreFileRequest;

use App\Containers\Files\Actions\RestoreFileAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class RestoreFile.
 *
 */
class RestoreFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\RestoreFileRequest $request
     * @param \App\Containers\Files\Actions\RestoreFileAction          $action
     *
     * @return  Response
     */
    public function restore(RestoreFileRequest $request, RestoreFileAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'File (' . $request->id . ') Restored Successfully.',
        ]);
    }

    
}
