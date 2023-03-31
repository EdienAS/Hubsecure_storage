<?php

namespace App\Containers\Folders\UI\Api\Controllers;

use App\Containers\Folders\UI\Api\Requests\GetFolderRequest;

use App\Containers\Zip\Actions\ZipAction;


use App\Abstracts\ControllerApi;
use Response;
/**
 * Class GetFolder.
 *
 */
class GetFolder extends ControllerApi
{

    /**
     * @param \App\Containers\Folders\UI\Api\Requests\GetFolderRequest $request
     * @param \App\Containers\Zip\Actions\ZipAction      $action
     *
     * @return Response
     */
    public function getFolder(GetFolderRequest $request, ZipAction $action)
    {
        $request->request->add(['items' => $request['uuid'] . '|folder']);
        return $action->run($request);
    }
    
}
