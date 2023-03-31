<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Tasks\UpdateMembersTask;
use App\Containers\Teams\Tasks\UpdateInvitationsTask;

/**
 * Class UpdateTeamFolderAction.
 *
 */
class UpdateTeamFolderAction extends Action
{
    /**
     * @var  \App\Containers\Teams\Tasks\UpdateInvitationsTask
     */
    private $updateInvitations;

    /**
     * @var  \App\Containers\Teams\Tasks\UpdateMembersTask
     */
    private $updateMembers;

    /**
     * UpdateFolderAction constructor.
     *
     * @param \App\Containers\Folders\Tasks\UpdateFolderTask     $updateFolderTask
     */
    public function __construct(UpdateInvitationsTask $updateInvitations,
        UpdateMembersTask $updateMembers)
    {
        $this->updateInvitations = $updateInvitations;
        $this->updateMembers = $updateMembers;
    }


    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {

        $data = $request->all();
        $folder = Folder::where('uuid', $data['uuid'])
                ->where('team_folder', true)->first();
                
        // Check if user didn't exceed max team members limit
        if (! $request->user()->canInviteTeamMembers($request->input('invitations'))) {
            abort(401, 'You exceed your members limit.');
        }
        
        //Update Invitations
        ($this->updateInvitations)($folder, $data['invitations']);
        
        //Update members
        ($this->updateMembers)($folder, $data['members']);
        
        return $folder->refresh();
    }
}
