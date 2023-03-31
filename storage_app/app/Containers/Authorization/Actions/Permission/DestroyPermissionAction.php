<?php

namespace App\Containers\Authorization\Actions\Permission;

use App\Abstracts\Action;
use App\Containers\Authorization\Tasks\Permission\DestroyPermissionTask;

/**
 * Class DestroyPermissionAction.
 *
 */
class DestroyPermissionAction extends Action
{

    /**
     * @var  \App\Containers\Authorization\Tasks\Permission\DestroyPermissionTask
     */
    private $deletePermissionTask;

    /**
     * DestroyPermissionAction constructor.
     *
     * @param \App\Containers\Authorization\Tasks\Permission\DestroyPermissionTask $deletePermissionTask
     */
    public function __construct(DestroyPermissionTask $deletePermissionTask)
    {
        $this->deletePermissionTask = $deletePermissionTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        $isDeleted = $this->deletePermissionTask->run($request->uuid);

        return $isDeleted;
    }
}
