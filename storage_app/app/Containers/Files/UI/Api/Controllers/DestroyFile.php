<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\DestroyFileRequest;

use App\Containers\Files\Actions\DestroyFileAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class DestroyFile.
 *
 */
class DestroyFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\DestroyFileRequest $request
     * @param \App\Containers\Files\Actions\DestroyFileAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyFileRequest $request, DestroyFileAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'File (' . $request->id . ') Deleted Successfully.',
        ]);
    }

    
}
