<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Zip\Actions\ZipAction;
use App\Containers\Share\UI\Api\Requests\PublicZipSharedItemRequest;
/**
 * Class PublicZipSharedItem.
 *
 */
class PublicZipSharedItem extends ControllerApi
{

    /**
     * Zip items publicly
     */
    
    public function zip(PublicZipSharedItemRequest $request, ZipAction $action,
        Share $shared)
    {
    
        return $action->run($request, $shared);
        
        
    }
    
}
