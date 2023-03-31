<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Files\Actions\UploadFileAction;
use App\Containers\Share\UI\Api\Requests\PublicUploadSharedItemRequest;
/**
 * Class PublicUploadSharedItem.
 *
 */
class PublicUploadSharedItem extends ControllerApi
{

    /**
     * Upload items publicly
     */
    
    public function upload(PublicUploadSharedItemRequest $request, UploadFileAction $action,
        Share $shared)
    {
    
        $upload = $action->run($request, $shared);
        return $this->responseCreated(null, [
            'message' => 'File(s) Uploaded Successfully.'
        ]);
        
    }
    
}
