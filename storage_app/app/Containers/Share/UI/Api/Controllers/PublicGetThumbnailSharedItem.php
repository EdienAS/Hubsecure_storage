<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Actions\PublicGetThumbnailSharedItemAction;
use App\Containers\Share\UI\Api\Requests\PublicGetThumbnailSharedItemRequest;
/**
 * Class PublicGetThumbnailSharedItem.
 *
 */
class PublicGetThumbnailSharedItem extends ControllerApi
{

    /**
     * Get details or download shared item publicly
     */
    
    public function getSharedThumbnail(PublicGetThumbnailSharedItemRequest $request, PublicGetThumbnailSharedItemAction $action,
            $temp = null, Share $shared)
    {
        return $action->run($request->name, $shared);
        
    }
    
}
