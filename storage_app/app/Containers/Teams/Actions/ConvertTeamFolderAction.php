<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Tasks\UpdateFolderTask;
use App\Containers\Teams\Tasks\CreateTeamFolderMemberTask;
use App\Containers\Teams\Tasks\InviteMembersIntoTeamFolderTask;
use App\Containers\Teams\Tasks\SetTeamFolderPropertyForAllChildrenTask;

/**
 * Class ConvertTeamFolderAction.
 *
 */
class ConvertTeamFolderAction extends Action
{

    /**
     * @var  \App\Containers\Folders\Tasks\UpdateFolderTask
     */
    private $updateFolderTask;

    /**
     * ConvertFolderAction constructor.
     *
     * @param \App\Containers\Folder\Tasks\UpdateFolderTask     $updateFolderTask
     * @param \App\Containers\Teams\Tasks\SetTeamFolderPropertyForAllChildrenTask     $setTeamFolderPropertyForAllChildrenTask
     */
    public function __construct(UpdateFolderTask $updateFolderTask,
        public SetTeamFolderPropertyForAllChildrenTask $setTeamFolderPropertyForAllChildrenTask,
        CreateTeamFolderMemberTask $createTeamFolderMemberTask,
        public InviteMembersIntoTeamFolderTask $inviteMembers
    ) {
        
        $this->updateFolderTask = $updateFolderTask;
        $this->createTeamFolderMemberTask = $createTeamFolderMemberTask;
    }
    
    
    /**
     * @param $request
     *
     * @return true
     */
    public function run($request)
    {
        $folder = Folder::where('uuid', $request->uuid)
                ->where('team_folder', 0)
                ->first();
        
        // Check if user didn't exceed max team members limit
        if (! $folder->user->canInviteTeamMembers($request->input('invitations'))) {
            return response()->json([
                'type'    => 'error',
                'message' => 'You exceed your members limit.',
            ], 401);
        }
        
        // Update root team folder
        $this->updateFolderTask->run(array(
                'team_folder' => true,
                'parent_folder_id'   => null
            ), 
            $request->uuid);

        // Change team_folder mark for all children folders
        ($this->setTeamFolderPropertyForAllChildrenTask)($folder, true);

        // Attach owner into members
        $this->createTeamFolderMemberTask->run($folder);
        
        // Invite team members
        ($this->inviteMembers)($request->invitations, $folder);
        
        return $folder->refresh();
    }
}
