<?php

namespace App\Containers\Notifications\UI\Api\Controllers;

use Response;
use App\Abstracts\ControllerApi;
use App\Containers\Notifications\Actions\ListNotificationAction;
use App\Containers\Notifications\UI\Api\Requests\ListNotificationRequest;
use App\Containers\Notifications\UI\Api\Transformers\ListNotificationTransformer;

/**
 * Class ListNotificationController.
 *
 */
class ListNotificationController extends ControllerApi
{

    /**
     * @param \App\Containers\Notifications\UI\Api\Requests\ListNotificationRequest $request
     * @param \App\Containers\Notifications\Actions\ListNotificationAction      $action
     *
     * @return Response
     */
    public function index(ListNotificationRequest $request, ListNotificationAction $action)
    {
        return $this->responseItem($action->run($request), new ListNotificationTransformer());
    }
    
}
