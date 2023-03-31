<?php

namespace App\Containers\Notifications\Actions;

use App\Abstracts\Action;
use App\Containers\Notifications\Tasks\ReadNotificationTask;

/**
 * Class ReadNotificationAction.
 *
 */
class ReadNotificationAction extends Action
{
    
    /**
     * @var  $readNotificationTask
     */
    private $readNotificationTask;

    /**
     * ReadNotificationAction constructor.
     *
     * @param \App\Containers\Notifications\Tasks\ReadNotificationTask     $readNotificationTask
     */
    public function __construct(ReadNotificationTask $readNotificationTask)
    {
        $this->readNotificationTask = $readNotificationTask;

    }

    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        return $this->readNotificationTask->run();
    }
}
