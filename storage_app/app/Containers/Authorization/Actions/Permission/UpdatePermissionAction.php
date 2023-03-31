<?php

namespace App\Containers\Authorization\Actions\Permission;

use App\Abstracts\Action;
use App\Containers\Authorization\Tasks\Permission\UpdatePermissionTask;

/**
 * Class UpdatePermissionAction.
 *
 */
class UpdatePermissionAction extends Action
{
    
    /**
     * @var  UpdatePermissionTask
     */
    private $updatePermissionTask;
    
    /**
     * UpdatePermissionTask constructor.
     *
     * @param \App\Containers\Authorization\Tasks\Permission\UpdatePermissionTask     $updatePermissionTask
     */
    public function __construct(
        UpdatePermissionTask $updatePermissionTask
    ) {
        $this->updatePermissionTask = $updatePermissionTask;
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return $this->updatePermissionTask->run($request->all());
    }
}
