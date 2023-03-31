<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Containers\Share\UI\Api\Requests\ShareItemRequest;

use App\Containers\Share\Actions\ShareItemAction;


use App\Containers\Share\UI\Api\Transformers\ShareItemTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShareItem.
 *
 */
class ShareItem extends ControllerApi
{

    /**
     * @param \App\Containers\Share\UI\Api\Requests\ShareItemRequest $request
     * @param \App\Containers\Share\Actions\ShareItemAction      $action
     *
     * @return Response
     */
    public function create(ShareItemRequest $request, ShareItemAction $action)
    {
        return $this->responseItem($action->run($request), new ShareItemTransformer());
    }
    
}
