<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Actions\PublicTrashSharedItemAction;
use App\Containers\Share\UI\Api\Requests\PublicTrashSharedItemRequest;
/**
 * Class PublicTrashSharedItem.
 *
 */
class PublicTrashSharedItem extends ControllerApi
{

    /**
     * Trash items publicly
     */
    
    public function trash(PublicTrashSharedItemRequest $request, PublicTrashSharedItemAction $action,
        Share $shared)
    {
        $action->run($request, $shared);
        return $this->responseNoContent([
            'message' => 'Item trashed successfully.'
        ]);
        
    }
    
}
