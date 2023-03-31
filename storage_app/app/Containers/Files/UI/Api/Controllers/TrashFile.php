<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\TrashFileRequest;

use App\Containers\Files\Actions\DestroyFileAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class TrashFile.
 *
 */
class TrashFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\TrashFileRequest $request
     * @param \App\Containers\Files\Actions\DestroyFileAction          $action
     *
     * @return  Response
     */
    public function trash(TrashFileRequest $request, DestroyFileAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'File (' . $request->id . ') Trashed Successfully.',
        ]);
    }

    
}
