<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\DestroyFolderRequest;

use App\Containers\Folders\Actions\DestroyFolderAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class DestroyFolder.
 *
 */
class DestroyFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\DestroyFolderRequest $request
     * @param \App\Containers\Folders\Actions\DestroyFolderAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyFolderRequest $request, DestroyFolderAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Folder (' . $request->uuid . ') Deleted Successfully.',
        ]);
    }

    
}
