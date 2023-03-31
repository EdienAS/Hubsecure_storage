<?php

namespace App\Containers\User\Actions;

use App\Abstracts\Action;
use App\Containers\User\Tasks\UpdateUserTask;

/**
 * Class UpdateUserAction.
 *
 */
class UpdateUserAction extends Action
{
    /**
     * @var  \App\Containers\User\Tasks\UpdateUserTask
     */
    private $updateUserTask;

    /**
     * UpdateUserAction constructor.
     *
     * @param \App\Containers\User\Tasks\UpdateUserTask     $updateUserTask
     */
    public function __construct(UpdateUserTask $updateUserTask)
    {
        $this->updateUserTask = $updateUserTask;

    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {

        $data = $request->all();

        return $this->updateUserTask->run($data, $request->uuid);
    }
}
