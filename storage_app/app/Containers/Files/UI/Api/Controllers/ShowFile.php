<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\ShowFileRequest;

use App\Containers\Files\Actions\ShowFileAction;


use App\Containers\Files\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowFile.
 *
 */
class ShowFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\ShowFileRequest $request
     * @param \App\Containers\Files\Actions\ShowFileAction      $action
     *
     * @return Response
     */
    public function show(ShowFileRequest $request, ShowFileAction $action)
    {
        return $this->responseItem($action->run($request), new FileTransformer());
    }
    
    public function getFile(){
        
    }
}
