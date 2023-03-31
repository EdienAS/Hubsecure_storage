<?php

namespace App\Containers\Teams\Actions;

use Auth;
use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;

/**
 * Class ListTeamFolderAction.
 *
 */
class ListTeamFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $folders = Folder::query();
        
        $folders->with('parent', 'teamMembers', 'teamInvitations', 'shared')
                ->where('team_folder', true)
                ->where('user_id', Auth::user()->id);
        
        if(!empty($request['orderBy']) && in_array($request['orderBy'], ['asc','desc'])){
            $folders->orderBy('created_at', $request['orderBy']);
        }

        if(!empty($request['limit']) && in_array($request['limit'], range( 1, 10 ))){
            $folders->limit($request['limit']);
        }
        
        return $folders->get();
    }
}
