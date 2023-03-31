<?php

namespace App\Containers\Browse\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Browse\Actions\BrowseTrashAction;
use App\Containers\Browse\UI\Api\Requests\BrowseTrashRequest;
use App\Containers\Browse\UI\Api\Transformers\BrowseTrashTransformer;

/**
 * Class BrowseTrash.
 *
 */
class BrowseTrash extends ControllerApi
{

    /**
     * @param \App\Containers\Browse\UI\Api\Requests\BrowseTrashRequest $request
     * @param \App\Containers\Browse\Actions\BrowseTrashAction      $action
     *
     * @return Response
     */
    public function get(BrowseTrashRequest $request, BrowseTrashAction $action)
    {
        return $this->responseItem($action->run($request->uuid), new BrowseTrashTransformer());
    }
    
}