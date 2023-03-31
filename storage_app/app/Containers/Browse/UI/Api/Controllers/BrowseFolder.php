<?php

namespace App\Containers\Browse\UI\Api\Controllers;

use App\Containers\Browse\UI\Api\Requests\BrowseFolderRequest;

use App\Containers\Browse\Actions\BrowseFolderAction;


use App\Containers\Browse\UI\Api\Transformers\BrowseFolderTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class BrowseFolder.
 *
 */
class BrowseFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Browse\UI\Api\Requests\BrowseFolderRequest $request
     * @param \App\Containers\Browse\Actions\BrowseFolderAction      $action
     *
     * @return Response
     */
    public function get(BrowseFolderRequest $request, BrowseFolderAction $action)
    {
        return $this->responseItem($action->run($request), new BrowseFolderTransformer());
    }
    
}
