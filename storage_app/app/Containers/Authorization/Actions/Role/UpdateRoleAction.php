<?php

namespace App\Containers\Authorization\Actions\Role;

use App\Abstracts\Action;
use App\Containers\Authorization\Tasks\Role\UpdateRoleTask;

/**
 * Class UpdateRoleAction.
 *
 */
class UpdateRoleAction extends Action
{
    
    
    /**
     * @var  UpdateRoleTask
     */
    private $updateRoleTask;
    
    
    /**
     * UpdateRoleTask constructor.
     *
     * @param \App\Containers\Authorization\Tasks\Role\UpdateRoleTask     $updateRoleTask
     */
    public function __construct(
        UpdateRoleTask $updateRoleTask
    ) {
        $this->updateRoleTask = $updateRoleTask;
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return $this->updateRoleTask->run($request->all());
    }
}
