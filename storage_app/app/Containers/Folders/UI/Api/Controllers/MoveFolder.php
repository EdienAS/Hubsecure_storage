<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\MoveFolderRequest;

 use App\Containers\Folders\Actions\UpdateFolderAction;


use App\Containers\Folders\UI\Api\Transformers\FolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class MoveFolder.
 *
 */
class MoveFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\MoveFolderRequest $request
     * @param \App\Containers\Folders\Actions\UpdateFolderAction        $action
     *
     * @return  Response
     */
    public function move(MoveFolderRequest $request, UpdateFolderAction $action)
    {
        
        // create (true parameter) the new role
        return $this->responseItem($action->run($request), new FolderTransformer());
    }

}
