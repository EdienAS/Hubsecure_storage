<?php

namespace App\Containers\Folders\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Tasks\TrashFolderTask;
use App\Containers\Folders\Tasks\DestroyFolderTask;

/**
 * Class DestroyFolderAction.
 *
 */
class DestroyFolderAction extends Action
{

    /**
     * @var  \App\Containers\Folders\Tasks\DestroyFolderTask
     * @var  \App\Containers\Folders\Tasks\TrashFolderTask
     */
    private $destroyFolderTask;
    private $trashFolderTask;

    /**
     * DestroyFolderAction constructor.
     *
     * @param \App\Containers\Folders\Tasks\DestroyFolderTask $destroyFolderTask
     */
    public function __construct(DestroyFolderTask $destroyFolderTask,
            TrashFolderTask $trashFolderTask)
    {
        $this->destroyFolderTask = $destroyFolderTask;
        $this->trashFolderTask = $trashFolderTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {        
        if(isset($request->force_delete) && $request->force_delete == 1){
            $isDeleted = $this->destroyFolderTask->run($request->uuid);
        } else {
            $isDeleted = $this->trashFolderTask->run($request->uuid);
        }

        return $isDeleted;
    }
}
