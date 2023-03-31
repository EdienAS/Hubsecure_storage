<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Facades\DB;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Exceptions\UpdateInvitationsException;

class UpdateInvitationsTask
{
    public function __construct(
        public InviteMembersIntoTeamFolderTask $inviteMembers,
    ) {
    }

    public function __invoke(Folder $folder, $invitations): void
    {
        try{
            
            // Get stored invitations from team folder
            $storedInvitations = $folder
                ->teamInvitations()
                ->pluck('email');

            // Get newbies added by user in request
            $newbies = collect($invitations)
                ->filter(
                    fn ($invitation) => ! in_array($invitation['email'], $storedInvitations->toArray())
                );

            // Get deleted invitations by user in request
            $removed = $storedInvitations->diff(
                collect($invitations)->pluck('email')->toArray()
            );

            // Invite team members
            if ($newbies->isNotEmpty()) {
                ($this->inviteMembers)($newbies->toArray(), $folder);
            }

            DB::beginTransaction();

            // Delete invite from team folder
            if ($removed->isNotEmpty()) {
                DB::table('team_folder_invitations')
                    ->where('parent_folder_id', $folder->id)
                    ->whereIn('email', $removed)
                    ->delete();
            }

            // Update privileges
            collect($invitations)
                ->each(
                    fn ($invitation) =>
                    DB::table('team_folder_invitations')
                        ->where('parent_folder_id', $folder->id)
                        ->where('email', $invitation['email'])
                        ->update([
                            'permission' => $invitation['permission'],
                        ])
                );
            
            DB::commit();
            
        } catch (\Exception $e) {
            throw (new UpdateInvitationsException())->debug($e);
        }
    }
}
