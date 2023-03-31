<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\ListTrashedFolderRequest;

use App\Containers\Folders\Actions\ListTrashedFolderAction;


use App\Containers\Folders\UI\Api\Transformers\ListFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListTrashedFolder.
 *
 */
class ListTrashedFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\ListTrashedFolderRequest $request
     * @param \App\Containers\Folders\Actions\ListTrashedFolderAction      $action
     *
     * @return Response
     */
    public function index(ListTrashedFolderRequest $request, ListTrashedFolderAction $action)
    {
        return $this->responseItem($action->run($request), new ListFolderTransformer());
    }
    
}
