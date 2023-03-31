<?php

namespace App\Containers\User\Actions;

use App\Abstracts\Action;
use App\Containers\User\Tasks\DeleteUserTask;

/**
 * Class DeleteUserAction.
 *
 */
class DeleteUserAction extends Action
{

    /**
     * @var  \App\Containers\User\Tasks\DeleteUserTask
     */
    private $deleteUserTask;

    /**
     * DeleteUserAction constructor.
     *
     * @param \App\Containers\User\Tasks\DeleteUserTask $deleteUserTask
     */
    public function __construct(DeleteUserTask $deleteUserTask)
    {
        $this->deleteUserTask = $deleteUserTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        $isDeleted = $this->deleteUserTask->run($request->uuid);

        return $isDeleted;
    }
}
