<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\ListFileRequest;

use App\Containers\Files\Actions\ListFileAction;


use App\Containers\Files\UI\Api\Transformers\ListFileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowFile.
 *
 */
class ListFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\ListFileRequest $request
     * @param \App\Containers\Files\Actions\ListFileAction      $action
     *
     * @return Response
     */
    public function index(ListFileRequest $request, ListFileAction $action)
    {
        return $this->responseItem($action->run($request), new ListFileTransformer());
    }
    
}
