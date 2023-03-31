<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\ListFolderRequest;

use App\Containers\Folders\Actions\ListFolderAction;


use App\Containers\Folders\UI\Api\Transformers\ListFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListFolder.
 *
 */
class ListFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\ListFolderRequest $request
     * @param \App\Containers\Folders\Actions\ListFolderAction      $action
     *
     * @return Response
     */
    public function index(ListFolderRequest $request, ListFolderAction $action)
    {
        return $this->responseItem($action->run($request), new ListFolderTransformer());
    }
    
}
