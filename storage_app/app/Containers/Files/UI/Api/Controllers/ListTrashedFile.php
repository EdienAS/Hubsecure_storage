<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\ListTrashedFileRequest;

use App\Containers\Files\Actions\ListTrashedFileAction;


use App\Containers\Files\UI\Api\Transformers\ListFileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ListTrashedFile.
 *
 */
class ListTrashedFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\ListTrashedFileRequest $request
     * @param \App\Containers\Files\Actions\ListTrashedFileAction      $action
     *
     * @return Response
     */
    public function index(ListTrashedFileRequest $request, ListTrashedFileAction $action)
    {
        return $this->responseItem($action->run($request), new ListFileTransformer());
    }
    
}
