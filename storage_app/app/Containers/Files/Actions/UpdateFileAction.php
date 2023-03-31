<?php

namespace App\Containers\Files\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Tasks\UpdateFileTask;
use App\Containers\Files\Resources\FileResource;

/**
 * Class UpdateFileAction.
 *
 */
class UpdateFileAction extends Action
{
    /**
     * @var  \App\Containers\Files\Tasks\UpdateFileTask
     */
    private $updateFileTask;

    /**
     * UpdateFileAction constructor.
     *
     * @param \App\Containers\Files\Tasks\UpdateFileTask     $updateFileTask
     */
    public function __construct(UpdateFileTask $updateFileTask)
    {
        $this->updateFileTask = $updateFileTask;

    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {

        $data = $request->all();

        $file = $this->updateFileTask->run($data, $request->uuid);
        
        return array('items' => array(new FileResource($file)));
    }
}
