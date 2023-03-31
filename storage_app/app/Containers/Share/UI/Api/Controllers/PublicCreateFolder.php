<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Actions\CreateFolderAction;
use App\Containers\Folders\UI\Api\Requests\CreateFolderRequest;
/**
 * Class PublicCreateFolder.
 *
 */
class PublicCreateFolder extends ControllerApi
{

    /**
     * Create folder publicly
     */
    
    public function create(CreateFolderRequest $request, CreateFolderAction $action,
        Share $shared)
    {
        $create = $action->run($request, $shared);
        return $this->responseCreated($create, [
            'message' => 'Folder created successfully.'
        ]);
        
    }
    
}
