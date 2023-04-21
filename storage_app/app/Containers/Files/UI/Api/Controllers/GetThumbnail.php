<?php

namespace App\Containers\Files\UI\Api\Controllers;

use App\Containers\Files\Actions\GetThumbnailAction;

use App\Containers\Files\UI\Api\Requests\GetThumbnailRequest;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class GetThumbnail.
 *
 */
class GetThumbnail extends ControllerApi
{

    /**
     * @param \App\Containers\Files\UI\Api\Requests\GetFileRequest $request
     * @param \App\Containers\Files\Actions\GetThumbnailAction      $action
     *
     * @return Response
     */
    public function getThumbnail(GetThumbnailRequest $request, GetThumbnailAction $action)
    {
        return $action->run($request);
    }
    
}
