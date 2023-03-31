<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Containers\Share\UI\Api\Requests\ShowShareItemRequest;
use App\Containers\Share\UI\Api\Requests\ShowShareItemPublicRequest;
use App\Containers\Share\Actions\ShowShareItemAction;


use App\Containers\Share\UI\Api\Transformers\ShareItemTransformer;
use App\Containers\Share\UI\Api\Transformers\ShareItemPublicTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowShareItem.
 *
 */
class ShowShareItem extends ControllerApi
{

    /**
     * @param \App\Containers\Share\UI\Api\Requests\ShowShareItemRequest $request
     * @param \App\Containers\Share\Actions\ShowShareItemAction      $action
     *
     * @return Response
     */
    public function show(ShowShareItemRequest $request, ShowShareItemAction $action)
    {
        return $this->responseItem($action->run($request), new ShareItemTransformer());
    }
    
    /**
     * @param \App\Containers\Share\UI\Api\Requests\ShowPublicShareItemRequest $request
     * @param \App\Containers\Share\Actions\ShowShareItemAction      $action
     *
     * @return Response
     */
    public function public(ShowShareItemPublicRequest $request, ShowShareItemAction $action)
    {
        return $this->responseItem($action->run($request), new ShareItemPublicTransformer());
    }
}
