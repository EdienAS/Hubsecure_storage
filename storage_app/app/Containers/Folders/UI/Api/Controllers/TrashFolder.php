<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\TrashFolderRequest;

use App\Containers\Folders\Actions\DestroyFolderAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class TrashFolder.
 *
 */
class TrashFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\TrashFolderRequest $request
     * @param \App\Containers\Folders\Actions\DestroyFolderAction          $action
     *
     * @return  Response
     */
    public function trash(TrashFolderRequest $request, DestroyFolderAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Folder (' . $request->id . ') Trashed Successfully.',
        ]);
    }

    
}
