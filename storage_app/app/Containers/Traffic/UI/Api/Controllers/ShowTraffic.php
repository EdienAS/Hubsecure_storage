<?php

namespace App\Containers\Traffic\UI\Api\Controllers;

use App\Containers\Traffic\UI\Api\Requests\ShowTrafficRequest;

use App\Containers\Traffic\Actions\ShowTrafficAction;


use App\Containers\Traffic\UI\Api\Transformers\TrafficTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowTraffic.
 *
 */
class ShowTraffic extends ControllerApi
{

    /**
     * @param \App\Containers\Traffic\UI\Api\Requests\ShowTrafficRequest $request
     * @param \App\Containers\Traffic\Actions\ShowTrafficAction      $action
     *
     * @return Response
     */
    public function show(ShowTrafficRequest $request, ShowTrafficAction $action)
    {
        return $this->responseItem($action->run($request), new TrafficTransformer());
    }
    
}
