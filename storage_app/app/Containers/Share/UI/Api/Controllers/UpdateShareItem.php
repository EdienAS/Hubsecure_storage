<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Containers\Share\UI\Api\Requests\UpdateShareItemRequest;

use App\Containers\Share\Actions\UpdateShareItemAction;


use App\Containers\Share\UI\Api\Transformers\ShareItemTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateShareItem.
 *
 */
class UpdateShareItem extends ControllerApi
{

    /**
     * @param \App\Containers\Share\UI\Api\Requests\UpdateShareItemRequest $request
     * @param \App\Containers\Share\Actions\UpdateShareItemAction      $action
     *
     * @return Response
     */
    public function update(UpdateShareItemRequest $request, UpdateShareItemAction $action)
    {
        return $this->responseItem($action->run($request), new ShareItemTransformer());
    }
    
}
