<?php

namespace App\Containers\Authorization\Actions\Permission;

use App\Abstracts\Action;
use App\Containers\Authorization\Tasks\Permission\CreatePermissionTask;

/**
 * Class CreatePermissionAction.
 *
 */
class CreatePermissionAction extends Action
{
    
    
    /**
     * @var  CreatePermissionTask
     */
    private $createPermissionTask;
    
    
    /**
     * CreatePermissionAction constructor.
     *
     * @param \App\Containers\Authorization\Tasks\Permission\CreatePermissionTask     $createPermissionTask
     */
    public function __construct(
        CreatePermissionTask $createPermissionTask
    ) {
        $this->createPermissionTask = $createPermissionTask;
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return $this->createPermissionTask->run($request->all());
    }
}
