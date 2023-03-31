<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Facades\DB;
use App\Containers\Teams\Models\TeamFolderMember;
use App\Containers\Teams\Exceptions\UpdateTeamMemberException;

class CreateTeamMemberTask
{
    public function __invoke($user, $invitation): void
    {
        try{
            
            DB::beginTransaction();
                // Store team member
                TeamFolderMember::updateOrCreate([
                    'user_id'    => $user->id,
                    'parent_folder_id'  => $invitation->parent_folder_id], [
                    'permission' => $invitation->permission
                ]);
            DB::commit();
            
        } catch (\Exception $e) {
            throw (new UpdateTeamMemberException())->debug($e);
        }
    }
}
