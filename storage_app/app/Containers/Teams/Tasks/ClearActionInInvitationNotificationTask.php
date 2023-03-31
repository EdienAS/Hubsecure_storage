<?php
namespace App\Containers\Teams\Tasks;

use DB;
use App\Containers\User\Models\User;
use App\Containers\Teams\Models\TeamFolderInvitation;

class ClearActionInInvitationNotificationTask
{
    public function __invoke(User $user, TeamFolderInvitation $invitation): void
    {
        // Get notification with invitation
        $notification = DB::table('notifications')
            ->where('notifiable_id', $user->id)
            ->where('data', 'LIKE', "%{$invitation->uuid}%")
            ->first();
            
        if ($notification) {
            // Get data
            $data = json_decode($notification->data);

            // Clear action object
            $data->action = null;
            
            DB::beginTransaction();

            // Update notification
            DB::table('notifications')
                ->where('notifiable_id', $user->id)
                ->where('data', 'LIKE', "%{$invitation->uuid}%")
                ->update([
                    'data' => json_encode($data),
                ]);
                

            DB::commit();

        }
    }
}
