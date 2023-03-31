<?php

namespace App\Containers\Folders\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Tasks\UpdateFolderTask;
use App\Containers\Folders\Resources\FolderResource;

/**
 * Class UpdateFolderAction.
 *
 */
class UpdateFolderAction extends Action
{
    /**
     * @var  \App\Containers\Folders\Tasks\UpdateFolderTask
     */
    private $updateFolderTask;

    /**
     * UpdateFolderAction constructor.
     *
     * @param \App\Containers\Folders\Tasks\UpdateFolderTask     $updateFolderTask
     */
    public function __construct(UpdateFolderTask $updateFolderTask)
    {
        $this->updateFolderTask = $updateFolderTask;

    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {

        $data = $request->all();

        $folder = $this->updateFolderTask->run($data, $request->uuid);
        
        return array('items' => array(new FolderResource($folder)));
        
    }
}
