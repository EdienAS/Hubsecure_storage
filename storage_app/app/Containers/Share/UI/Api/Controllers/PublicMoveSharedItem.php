<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Actions\PublicMoveSharedItemAction;
use App\Containers\Share\UI\Api\Requests\PublicMoveSharedItemRequest;
/**
 * Class PublicMoveSharedItem.
 *
 */
class PublicMoveSharedItem extends ControllerApi
{

    /**
     * Move items publicly
     */
    
    public function update(PublicMoveSharedItemRequest $request, PublicMoveSharedItemAction $action,
        Share $shared)
    {
        $action->run($request, $shared);
        return $this->responseNoContent([
            'message' => 'Item moved successfully.'
        ]);
        
    }
    
}
