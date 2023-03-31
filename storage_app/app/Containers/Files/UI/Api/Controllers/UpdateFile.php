<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\UI\Api\Requests\UpdateFileRequest;

 use App\Containers\Files\Actions\UpdateFileAction;


use App\Containers\Files\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateFile.
 *
 */
class UpdateFile extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\UpdateFileRequest $request
     * @param \App\Containers\Files\Actions\UpdateFileAction        $action
     *
     * @return  Response
     */
    public function update(UpdateFileRequest $request, UpdateFileAction $action)
    {
        
        // create (true parameter) the new role
        return $this->responseItem($action->run($request), new FileTransformer());
    }

}
