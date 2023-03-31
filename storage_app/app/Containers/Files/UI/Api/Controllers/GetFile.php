<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\GetFileRequest;

use App\Containers\Files\Actions\GetFileAction;


use App\Containers\Files\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class GetFile.
 *
 */
class GetFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\GetFileRequest $request
     * @param \App\Containers\Files\Actions\GetFileAction      $action
     *
     * @return Response
     */
    public function getFile(GetFileRequest $request, GetFileAction $action)
    {
        return $action->run($request);
    }
    
}
