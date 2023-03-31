<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Containers\Share\UI\Api\Requests\DestroyShareItemRequest;

use App\Containers\Share\Actions\DestroyShareItemAction;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class DestroyShareItem.
 *
 */
class DestroyShareItem extends ControllerApi
{

    /**
     * @param \App\Containers\Share\UI\Api\Requests\DestroyShareItemRequest $request
     * @param \App\Containers\Share\Actions\DestroyShareItemAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyShareItemRequest $request, DestroyShareItemAction $action)
    {
        $action->run($request);
        
        return $this->responseNoContent([
            'message' => 'Share Item (' . implode(',',$request->input('tokens')) . ') Deleted Successfully.',
        ]);
    }

    
}
