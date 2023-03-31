<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Permission;

use Response;
use App\Abstracts\ControllerApi;

use App\Containers\Authorization\Actions\Permission\DestroyPermissionAction;
 
 use App\Containers\Authorization\UI\Api\Requests\Permission\DestroyPermissionRequest;

/**
 * Class DestroyPermission.
 *
 */
class DestroyPermission extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Permission\DestroyPermissionRequest $request
     * @param \App\Containers\Authorization\Actions\Permission\DestroyPermissionAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyPermissionRequest $request, DestroyPermissionAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Permission (' . $request->uuid . ') Deleted Successfully.',
        ]);
    }

    
}
