<?php

namespace App\Containers\Notifications\Actions;

use App\Abstracts\Action;
use App\Containers\Notifications\Tasks\DestroyNotificationTask;

/**
 * Class DestroyNotificationAction.
 *
 */
class DestroyNotificationAction extends Action
{
    
    /**
     * @var  $destroyNotificationTask
     */
    private $destroyNotificationTask;

    /**
     * ReadNotificationAction constructor.
     *
     * @param \App\Containers\Notifications\Tasks\ReadNotificationTask     $destroyNotificationTask
     */
    public function __construct(DestroyNotificationTask $destroyNotificationTask)
    {
        $this->destroyNotificationTask = $destroyNotificationTask;

    }

    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        return $this->destroyNotificationTask->run();
    }
}
