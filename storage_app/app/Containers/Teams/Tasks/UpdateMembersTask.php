<?php
namespace App\Containers\Teams\Tasks;

use DB;
use App\Containers\Folders\Models\Folder;
use App\Containers\Teams\Exceptions\UpdateMembersException;

class UpdateMembersTask
{
    public function __invoke(Folder $folder, $members): void
    {
        try{
            
            DB::beginTransaction();

            $existingMembers = $folder
                ->teamMembers()
                ->pluck('user_id');

            // Get deleted members from request
            $deletedMembers = $existingMembers->diff(
                collect($members)->pluck('id')->toArray()
            );

            // Remove team members from team folder
            if ($deletedMembers->isNotEmpty()) {
                DB::table('team_folder_members')
                    ->where('parent_folder_id', $folder->id)
                    ->whereIn('user_id', $deletedMembers->toArray())
                    ->delete();
            }

            // Update privileges
            collect($members)
                ->each(
                    fn ($member) =>
                    DB::table('team_folder_members')
                        ->where('parent_folder_id', $folder->id)
                        ->where('user_id', $member['id'])
                        ->update([
                            'permission' => $member['permission'],
                        ])
                );
        
            DB::commit();
            
        } catch (\Exception $e) {
            throw (new UpdateMembersException())->debug($e);
        }
    }
}
