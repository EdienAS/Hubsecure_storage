<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Actions\PublicGetSharedItemAction;
use App\Containers\Share\UI\Api\Requests\PublicGetSharedItemRequest;
/**
 * Class PublicGetSharedItem.
 *
 */
class PublicGetSharedItem extends ControllerApi
{

    /**
     * Get details or download shared item publicly
     */
    
    public function get(PublicGetSharedItemRequest $request, PublicGetSharedItemAction $action)
    {
        return $action->run($request);
        
    }
    
}
