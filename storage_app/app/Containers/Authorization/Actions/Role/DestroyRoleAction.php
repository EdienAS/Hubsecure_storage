<?php

namespace App\Containers\Authorization\Actions\Role;

use App\Containers\Authorization\Tasks\Role\DestroyRoleTask;
use App\Abstracts\Action;

/**
 * Class DestroyRoleAction.
 *
 */
class DestroyRoleAction extends Action
{

    /**
     * @var  \App\Containers\Authorization\Tasks\Role\DestroyRoleTask
     */
    private $destroyRoleTask;

    /**
     * DestroyRoleAction constructor.
     *
     * @param \App\Containers\User\Tasks\Role\DestroyRoleTask $destroyRoleTask
     */
    public function __construct(DestroyRoleTask $destroyRoleTask)
    {
        $this->destroyRoleTask = $destroyRoleTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        $isDeleted = $this->destroyRoleTask->run($request->uuid);

        return $isDeleted;
    }
}
