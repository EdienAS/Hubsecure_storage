<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\ShowFolderRequest;

use App\Containers\Folders\Actions\ShowFolderAction;


use App\Containers\Folders\UI\Api\Transformers\FolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowFolder.
 *
 */
class ShowFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\ShowFolderRequest $request
     * @param \App\Containers\Folders\Actions\ShowFolderAction      $action
     *
     * @return Response
     */
    public function show(ShowFolderRequest $request, ShowFolderAction $action)
    {
        return $this->responseItem($action->run($request), new FolderTransformer());
    }
    
}
