<?php

namespace App\Containers\Zip\UI\Api\Controllers;

use App\Containers\Zip\UI\Api\Requests\ZipRequest;

use App\Containers\Zip\Actions\ZipAction;


//use App\Containers\Zip\UI\Api\Transformers\FileTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class Zip.
 *
 */
class Zip extends ControllerApi
{

    /**
     * @param \App\Containers\Zip\UI\Api\Requests\ZipRequest $request
     * @param \App\Containers\Zip\Actions\ZipAction      $action
     *
     * @return Response
     */
    public function zip(ZipRequest $request, ZipAction $action)
    {
        return $action->run($request);
    }
    
}
