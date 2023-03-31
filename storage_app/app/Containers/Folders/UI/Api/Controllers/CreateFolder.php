<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\CreateFolderRequest;

 use App\Containers\Folders\Actions\CreateFolderAction;


use App\Containers\Folders\UI\Api\Transformers\FolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class CreateFolder.
 *
 */
class CreateFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\CreateFolderRequest $request
     * @param \App\Containers\Folders\Actions\CreateFolderAction        $action
     *
     * @return  Response
     */
    public function create(CreateFolderRequest $request, CreateFolderAction $action)
    {
        
        // create new folder
        return $this->responseItem($action->run($request), new FolderTransformer());
    }

}
