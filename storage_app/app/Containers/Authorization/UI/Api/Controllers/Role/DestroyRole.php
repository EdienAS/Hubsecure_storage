<?php

namespace App\Containers\Authorization\UI\Api\Controllers\Role;

 use App\Containers\Authorization\UI\Api\Requests\Role\DestroyRoleRequest;

 use App\Containers\Authorization\Actions\Role\DestroyRoleAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class DestroyRole.
 *
 */
class DestroyRole extends ControllerApi
{

    /**
     * @param \App\Containers\Authorization\UI\Api\Requests\Role\DestroyRoleRequest $request
     * @param \App\Containers\Authorization\Actions\Role\DestroyRoleAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyRoleRequest $request, DestroyRoleAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'Role (' . $request->id . ') Deleted Successfully.',
        ]);
    }

    
}
