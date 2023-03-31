<?php

namespace App\Containers\Folders\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Resources\FolderResource;

/**
 * Class ShowFolderAction.
 *
 */
class ShowFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $folder = Folder::with('files', 'folders')->where('uuid', $request->uuid)->first();
        
        return array('items' => array(new FolderResource($folder)));
    }
}
