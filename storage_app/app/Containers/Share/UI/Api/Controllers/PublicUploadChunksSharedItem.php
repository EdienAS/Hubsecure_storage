<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Files\Actions\UploadChunksAction;
use App\Containers\Share\UI\Api\Requests\PublicUploadChunksSharedItemRequest;
/**
 * Class PublicUploadChunksSharedItem.
 *
 */
class PublicUploadChunksSharedItem extends ControllerApi
{

    /**
     * Upload Chunks publicly
     */
    
    public function uploadChunks(PublicUploadChunksSharedItemRequest $request, UploadChunksAction $action,
        Share $shared)
    {
    
        $uploadChunks = $action->run($request, $shared);
        return $this->responseCreated(null, [
            'message' => 'Item(s) Uploaded Successfully.'
        ]);
        
    }
    
}
