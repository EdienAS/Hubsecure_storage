<?php
namespace App\Containers\Teams\Tasks;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use App\Containers\Folders\Models\Folder;
use Illuminate\Support\Facades\Notification;
use App\Containers\Teams\Models\TeamFolderInvitation;
use App\Containers\Teams\Notifications\InvitationIntoTeamFolder;
use App\Containers\Teams\Exceptions\InviteMembersIntoTeamFolderException;

class InviteMembersIntoTeamFolderTask
{
    
    public function __invoke(
        array $members,
        Folder $folder,
    ): void {
        try {
            
            collect($members)
                ->each(function ($member) use ($folder) {

                    // Get user
                    $user = User::where('email', $member['email'])->first();
                    
                    if($member['email'] != Auth::user()->email){

                        DB::beginTransaction();

                        // Create invitation
                        $invitation = TeamFolderInvitation::updateOrCreate([
                            'parent_folder_id'  => $folder->id,
                            'email'      => $member['email'],
                        ], [
                            'uuid'       => 'uuid',
                            'permission' => $member['permission'],
                            'inviter_id' => $folder->user_id,
                        ]);

                        DB::commit();
                        
                        if ($user) {
                            // Invite native user
                            $user->notify(new InvitationIntoTeamFolder($folder, $invitation));
                        } else {
                            // Invite guest
                            // Get default app locale
                            $appLocale = get_settings('language') ?? 'en';

                            Notification::route('mail', $member['email'])
                                ->notify(
                                    (new InvitationIntoTeamFolder($folder, $invitation))->locale($appLocale)
                                );
                        }
                    }
                    
                });

        } catch (\Exception $e) {
            throw (new InviteMembersIntoTeamFolderException())->debug($e);
        }
    }
}
