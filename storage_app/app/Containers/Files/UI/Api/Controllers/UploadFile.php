<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\UploadFileRequest;

use App\Containers\Files\Actions\UploadFileAction;

use App\Containers\Files\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UploadFile.
 *
 */
class UploadFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\UploadFileRequest $request
     * @param \App\Containers\Files\Actions\UploadFileAction        $action
     *
     * @return  Response
     */
    public function upload(UploadFileRequest $request, UploadFileAction $action)
    {
        
        // create (true parameter) the new role
        return $this->responseItem($action->run($request), new FileTransformer());
    }

}
