<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\Teams\DTO\CreateTeamFolderData;
use App\Containers\Folders\Tasks\CreateTeamFolderTask;
use App\Containers\Teams\Tasks\CreateTeamFolderMemberTask;
use App\Containers\Teams\Tasks\InviteMembersIntoTeamFolderTask;

/**
 * Class CreateTeamFolderAction.
 *
 */
class CreateTeamFolderAction extends Action
{

    /**
     * @var  CreateTeamFolderTask
     */
    private $createTeamFolderTask;
    
    /**
     * @var  CreateTeamFolderMemberTask
     */
    private $createTeamFolderMemberTask;
    
    /**
     * CreateTeamFolderAction constructor.
     *
     * @param \App\Containers\Folder\Tasks\CreateTeamFolderTask     $createTeamFolderTask
     */
    public function __construct(
        CreateTeamFolderTask $createTeamFolderTask,
        CreateTeamFolderMemberTask $createTeamFolderMemberTask,
        public InviteMembersIntoTeamFolderTask $inviteMembers,
    ) {
        
        $this->createTeamFolderTask = $createTeamFolderTask;
        $this->createTeamFolderMemberTask = $createTeamFolderMemberTask;
    }
    
    
    /**
     * @param $request
     *
     * @return teamfolder
     */
    public function run($request)
    {
        
        $teamFolderdata = CreateTeamFolderData::fromRequest($request);

        // Check if user can create team folder
        if (! $request->user()->canCreateTeamFolder()) {
            abort(401, 'This user action is not allowed.');
        }

        // Check if user didn't exceed max team members limit
        if (! $request->user()->canInviteTeamMembers($teamFolderdata->invitations)) {
            abort(401, 'You exceed your members limit.');
        }

        $data = $request->all();
        
        $data['team_folder'] = true;

        //Create Team Folder
        $teamFolder = $this->createTeamFolderTask->run($data);
        
        $this->createTeamFolderMemberTask->run($teamFolder);
        
        // Invite team members
        ($this->inviteMembers)($data['invitations'], $teamFolder);

        return $teamFolder;
    }
}
