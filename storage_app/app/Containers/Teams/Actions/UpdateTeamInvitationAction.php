<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\User\Models\User;
use App\Containers\Teams\Tasks\CreateTeamMemberTask;
use App\Containers\Teams\Models\TeamFolderInvitation;
use App\Containers\Teams\Tasks\UpdateTeamInvitationTask;

/**
 * Class UpdateTeamInvitationAction.
 *
 */
class UpdateTeamInvitationAction extends Action
{
    /**
     * @var  \App\Containers\Teams\Tasks\CreateTeamMemberTask
     */
    private $createTeamMemberTask;

    /**
     * @var  \App\Containers\Teams\Tasks\UpdateTeamInvitationTask
     */
    private $updateTeamInvitationTask;

    /**
     * UpdateFolderAction constructor.
     *
     * @param \App\Containers\Teams\Tasks\CreateTeamMemberTask     $createTeamMemberTask
     * @param \App\Containers\Teams\Tasks\UpdateTeamInvitationTask     $updateTeamInvitationTask
     */
    public function __construct(CreateTeamMemberTask $createTeamMemberTask,
            UpdateTeamInvitationTask $updateTeamInvitationTask)
    {
        $this->createTeamMemberTask = $createTeamMemberTask;
        $this->updateTeamInvitationTask = $updateTeamInvitationTask;

    }
    
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
            abort(422, 'Invitation was already used.');
        }
        
        // Get invited user
        $user = User::where('email', $invitation->email)
            ->first();
        
        if ($user) {
            
            $invitation->accept();

            ($this->createTeamMemberTask)($user, $invitation);
        } else {
            $data = array(
                'status' => 'waiting-for-registration'
            );
            
            ($this->updateTeamInvitationTask)($data, $invitation);
        }
        
        return $invitation->refresh();

    }
}
