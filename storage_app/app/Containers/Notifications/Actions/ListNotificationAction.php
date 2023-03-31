<?php

namespace App\Containers\Notifications\Actions;

use App\Abstracts\Action;
use App\Containers\Notifications\Resources\NotificationCollection;

/**
 * Class ListNotificationAction.
 *
 */
class ListNotificationAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        $notifications = new NotificationCollection(
            auth()->user()->notifications
        );

        return array($notifications);
    }
}
