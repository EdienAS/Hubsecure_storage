<?php

namespace App\Containers\Files\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Tasks\TrashFileTask;
use App\Containers\Files\Tasks\DestroyFileTask;

/**
 * Class DestroyFileAction.
 *
 */
class DestroyFileAction extends Action
{

    /**
     * @var  \App\Containers\Files\Tasks\DestroyFileTask
     * @var  \App\Containers\Files\Tasks\TrashFileTask
     */
    private $destroyFileTask;
    private $trashFileTask;

    /**
     * DestroyFileAction constructor.
     *
     * @param \App\Containers\Files\Tasks\DestroyFileTask $destroyFileTask
     */
    public function __construct(DestroyFileTask $destroyFileTask,
            TrashFileTask $trashFileTask)
    {
        $this->destroyFileTask = $destroyFileTask;
        $this->trashFileTask = $trashFileTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {        
        if(isset($request->force_delete) && $request->force_delete == 1){
            $isDeleted = $this->destroyFileTask->run($request->uuid);
        } else {
            $isDeleted = $this->trashFileTask->run($request->uuid);
        }

        return $isDeleted;
    }
}
