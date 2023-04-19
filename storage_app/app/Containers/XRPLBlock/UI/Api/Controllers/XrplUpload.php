<?php

namespace App\Containers\XRPLBlock\UI\Api\Controllers;

use App\Containers\XRPLBlock\UI\Api\Requests\XrplUploadRequest;

use App\Containers\XRPLBlock\Actions\XrplUploadAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class XrplUpload.
 *
 */
class XrplUpload extends ControllerApi
{

    /**
     * @param \App\Containers\XRPLBlock\UI\Api\Requests\XrplUploadRequest $request
     * @param \App\Containers\XRPLBlock\Actions\XrplUploadAction      $action
     *
     * @return Response
     */
    public function upload(XrplUploadRequest $request, XrplUploadAction $action)
    {
        return $action->run($request);
    }
    
}
