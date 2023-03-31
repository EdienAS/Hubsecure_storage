<?php

namespace App\Containers\Notifications\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Notifications\Actions\ReadNotificationAction;
use App\Containers\Notifications\UI\Api\Requests\ReadNotificationRequest;

/**
 * Class ReadNotificationController.
 *
 */
class ReadNotificationController extends ControllerApi
{

    /**
     * @param \App\Containers\Notifications\UI\Api\Requests\ReadNotificationRequest $request
     * @param \App\Containers\Notifications\Actions\ReadNotificationAction      $action
     *
     * @return Response
     */
    public function read(ReadNotificationRequest $request, ReadNotificationAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'All Notifications Read Successfully.',
        ]);
    }
    
}
