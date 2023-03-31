<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\MoveFileRequest;

 use App\Containers\Files\Actions\UpdateFileAction;


use App\Containers\Files\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class MoveFile.
 *
 */
class MoveFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\MoveFileRequest $request
     * @param \App\Containers\Files\Actions\UpdateFileAction        $action
     *
     * @return  Response
     */
    public function move(MoveFileRequest $request, UpdateFileAction $action)
    {
        
        // create (true parameter) the new role
        return $this->responseItem($action->run($request), new FileTransformer());
    }

}
