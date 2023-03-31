<?php

namespace App\Containers\Teams\Actions;

use App\Abstracts\Action;
use App\Containers\User\Models\User;
use App\Containers\Teams\Models\TeamFolderInvitation;
use App\Containers\Teams\Tasks\ClearActionInInvitationNotificationTask;

/**
 * Class DestroyTeamInvitationAction.
 *
 */
class DestroyTeamInvitationAction extends Action
{
    /**
     * @var  \App\Containers\Teams\Tasks\ClearActionInInvitationNotificationTask
     */
    private $clearActionInInvitationNotification;

    /**
     * UpdateFolderAction constructor.
     *
     * @param \App\Containers\Folders\Tasks\ClearActionInInvitationNotificationTask     $clearActionInInvitationNotification
     */
    public function __construct(
        ClearActionInInvitationNotificationTask $clearActionInInvitationNotification)
    {
        $this->clearActionInInvitationNotification = $clearActionInInvitationNotification;
    }


    /**
     * @param $request
     *
     * @return true
     */
    public function run($request)
    {
        $invitation = TeamFolderInvitation::where('uuid', $request->uuid)->first();
        
        // Check if invitation is not pending
        if ($invitation->status !== 'pending') {
            abort(422, 'Invitation was already used.');
        }
        
        $invitation->reject();

        // Get user from invitation
        $user = User::where('email', $invitation->email)
            ->first();

        // Clear action in existing notification
        if ($user) {
            ($this->clearActionInInvitationNotification)($user, $invitation);
        }

        return true;
    }
}
