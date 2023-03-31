<?php

namespace App\Containers\User\Actions\Blacklist;

use App\Abstracts\Action;
use App\Containers\User\Tasks\Blacklist\DestroyBlacklistTask;

/**
 * Class DestroyBlacklistAction.
 *
 */
class DestroyBlacklistAction extends Action
{

    /**
     * @var  \App\Containers\User\Tasks\Blacklist\DestroyBlacklistTask
     */
    private $destroyBlacklistTask;

    /**
     * DestroyBlacklistAction constructor.
     *
     * @param \App\Containers\User\Tasks\Blacklist\DestroyBlacklistTask $destroyBlacklistTask
     */
    public function __construct(DestroyBlacklistTask $destroyBlacklistTask)
    {
        $this->destroyBlacklistTask = $destroyBlacklistTask;
    }
    
    
    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        $isDeleted = $this->destroyBlacklistTask->run($request->uuid);

        return $isDeleted;
    }
}
