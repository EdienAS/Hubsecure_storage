<?php

namespace App\Containers\Files\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Files\Resources\FileResource;

/**
 * Class ShowFileAction.
 *
 */
class ShowFileAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $file = File::with('parent', 'creator')->where('uuid', $request->uuid)
                ->first();
        
        return array('items' => array(new FileResource($file)));
    }
}
