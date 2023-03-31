<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Actions\PublicUpdateSharedItemAction;
use App\Containers\Share\UI\Api\Requests\PublicUpdateSharedItemRequest;
/**
 * Class PublicUpdateSharedItem.
 *
 */
class PublicUpdateSharedItem extends ControllerApi
{

    /**
     * Update items publicly
     */
    
    public function update(PublicUpdateSharedItemRequest $request, PublicUpdateSharedItemAction $action,
        string $id,
        Share $shared)
    {
    
        $action->run($request, $id, $shared);
        return $this->responseNoContent([
            'message' => 'Item updated successfully.'
        ]);
        
    }
    
}
