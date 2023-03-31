<?php

namespace App\Containers\Authorization\Actions\Role;

use App\Abstracts\Action;
use App\Containers\Authorization\Tasks\Role\CreateRoleTask;

/**
 * Class CreateRoleAction.
 *
 */
class CreateRoleAction extends Action
{
    
    
    /**
     * @var  CreateRoleTask
     */
    private $createRoleTask;
    
    
    /**
     * CreateRoleAction constructor.
     *
     * @param \App\Containers\Authorization\Tasks\Role\CreateRoleTask     $createRoleTask
     */
    public function __construct(
        CreateRoleTask $createRoleTask
    ) {
        $this->createRoleTask = $createRoleTask;
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return $this->createRoleTask->run($request->all());
    }
}
