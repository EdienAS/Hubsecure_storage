<?php

namespace App\Containers\Browse\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Browse\Actions\BrowseSharedWithMeAction;
use App\Containers\Browse\UI\Api\Requests\BrowseSharedWithMeRequest;
use App\Containers\Browse\UI\Api\Transformers\BrowseSharedWithMeTransformer;

/**
 * Class BrowseSharedWithMe.
 *
 */
class BrowseSharedWithMe extends ControllerApi
{

    /**
     * @param \App\Containers\Teams\UI\Api\Requests\BrowseSharedWithMeRequest $request
     * @param \App\Containers\Teams\Actions\BrowseSharedWithMeAction      $action
     *
     * @return Response
     */
    public function get(BrowseSharedWithMeRequest $request, BrowseSharedWithMeAction $action, $uuid = null)
    {
        return $this->responseItem($action->run($request, $uuid), new BrowseSharedWithMeTransformer());
    }
    
}
