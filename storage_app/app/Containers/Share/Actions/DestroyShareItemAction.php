<?php

namespace App\Containers\Share\Actions;

use App\Containers\Share\Tasks\DestroyShareItemTask;
use App\Abstracts\Action;

/**
 * Class DestroyShareItemAction.
 *
 */
class DestroyShareItemAction extends Action
{

    /**
     * @var  \App\Containers\Share\Tasks\DestroyShareItemTask
     */
    private $destroyShareItemTask;

    /**
     * DestroyShareItemAction constructor.
     *
     * @param \App\Containers\ShareItems\Tasks\DestroyShareItemTask $destroyShareItemTask
     */
    public function __construct(DestroyShareItemTask $destroyShareItemTask)
    {
        $this->destroyShareItemTask = $destroyShareItemTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {        
            $isDeleted = $this->destroyShareItemTask->run($request);

        return $isDeleted;
    }
}
