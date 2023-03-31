<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Teams\Models\TeamFolderInvitation;

/**
 * Class ShowTeamInvitationAction.
 *
 */
class ShowTeamInvitationAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $invitation = TeamFolderInvitation::where('uuid', $request->uuid)->first();
        
        // Check if invitation is not pending
        if ($invitation->status !== 'pending') {
            abort(410, 'Invitation was already used.');
        }
        
        return $invitation;
        
    }
}
