<?php

namespace App\Containers\Teams\Actions;

use Auth;
use App\Abstracts\Action;
use App\Containers\Teams\Models\TeamFolderInvitation;

/**
 * Class ListTeamInvitationAction.
 *
 */
class ListTeamInvitationAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $teamInvitations = TeamFolderInvitation::query();
        
        if(!empty($request['type']) && $request['type'] == 'sent'){
            $teamInvitations->where('inviter_id', auth()->user()->id);
        } else{
            
            $teamInvitations->where('status', 'pending');
        
            $teamInvitations->where('email', auth()->user()->email);
        }
        
        if(!empty($request['orderBy']) && in_array($request['orderBy'], ['asc','desc'])){
            $teamInvitations->orderBy('created_at', $request['orderBy']);
        }

        if(!empty($request['limit']) && in_array($request['limit'], range( 1, 10 ))){
            $teamInvitations->limit($request['limit']);
        }
        
        
        return $teamInvitations->get();
    }
}
