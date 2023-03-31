<?php

namespace App\Containers\Files\Actions;

use App\Containers\Files\Tasks\RestoreTask;
use App\Abstracts\Action;

/**
 * Class RestoreFileAction.
 *
 */
class RestoreFileAction extends Action
{

    /**
     * @var  \App\Containers\Files\Tasks\RestoreTask
     */
    private $restoreTask;

    /**
     * DestroyFileAction constructor.
     *
     * @param \App\Containers\Files\Tasks\RestoreTask $restoreTask
     */
    public function __construct(RestoreTask $restoreTask)
    {
        $this->restoreTask = $restoreTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {        
            $isRestored = $this->restoreTask->run($request);

        return $isRestored;
    }
}
