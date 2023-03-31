<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;

/**
 * Class ShowTeamFolderAction.
 *
 */
class ShowTeamFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        return Folder::with('files', 'folders')
                ->where('team_folder', true)
                ->where('uuid', $request->uuid)
                ->first();
    }
}
