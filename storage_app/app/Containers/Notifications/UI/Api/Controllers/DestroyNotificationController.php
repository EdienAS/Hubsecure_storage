<?php

namespace App\Containers\Notifications\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Notifications\Actions\DestroyNotificationAction;
use App\Containers\Notifications\UI\Api\Requests\DestroyNotificationRequest;

/**
 * Class DestroyNotificationController.
 *
 */
class DestroyNotificationController extends ControllerApi
{

    /**
     * @param \App\Containers\Notifications\UI\Api\Requests\DestroyNotificationRequest $request
     * @param \App\Containers\Notifications\Actions\DestroyNotificationAction      $action
     *
     * @return Response
     */
    public function destroy(DestroyNotificationRequest $request, DestroyNotificationAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'All Notifications Destroy Successfully.',
        ]);
    }
    
}
