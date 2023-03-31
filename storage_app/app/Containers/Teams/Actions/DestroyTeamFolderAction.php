<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Tasks\UpdateFolderTask;
use App\Containers\Teams\Tasks\DestroyAttachedMembersTask;
use App\Containers\Teams\Tasks\DestroyExistingInvitationsTask;
use App\Containers\Teams\Tasks\SetTeamFolderPropertyForAllChildrenTask;

/**
 * Class DestroyTeamFolderAction.
 *
 */
class DestroyTeamFolderAction extends Action
{
    /**
     * @var  \App\Containers\Teams\Tasks\DestroyExistingInvitationsTask
     */
    private $destroyExistingInvitations;

    /**
     * @var  \App\Containers\Teams\Tasks\UpdateMembersTask
     */
    private $destroyAttachedMembers;

    /**
     * UpdateFolderAction constructor.
     *
     * @param \App\Containers\Folders\Tasks\UpdateFolderTask     $updateFolderTask
     */
    public function __construct(DestroyExistingInvitationsTask $destroyExistingInvitations,
        DestroyAttachedMembersTask $destroyAttachedMembers,
        public SetTeamFolderPropertyForAllChildrenTask $setTeamFolderPropertyForAllChildrenTask,
            UpdateFolderTask $updateFolderTask)
    {
        $this->destroyExistingInvitations = $destroyExistingInvitations;
        $this->destroyAttachedMembers = $destroyAttachedMembers;
        $this->updateFolderTask = $updateFolderTask;
    }


    /**
     * @param $request
     *
     * @return true
     */
    public function run($request)
    {
        $folder = Folder::where('uuid', $request->uuid)->first();
        if (! $folder->team_folder) {
            abort(401, "You're trying to access non-team folder.");
        }
        
        // Delete existing invitations
        ($this->destroyExistingInvitations)($folder);
        
        // Delete attached members from folder
        ($this->destroyAttachedMembers)($folder);
        
        // Change team_folder mark for all children folders
        ($this->setTeamFolderPropertyForAllChildrenTask)($folder, false);

        //Update folder
        $this->updateFolderTask->run(array('team_folder' => false), $request->uuid);
        
        return true;
    }
}
