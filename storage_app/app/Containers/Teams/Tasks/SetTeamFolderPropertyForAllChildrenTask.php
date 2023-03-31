<?php
namespace App\Containers\Teams\Tasks;

use Illuminate\Support\Arr;
use App\Containers\Folders\Models\Folder;
use Illuminate\Support\Facades\DB;

class SetTeamFolderPropertyForAllChildrenTask
{
    public function __invoke(Folder $folder, bool $isTeamFolder)
    {
        try{
            
            DB::beginTransaction();

            // Get all children of team folder
            $childrenFolderIds = Folder::with('folders:id,parent_folder_id')
                ->where('id', $folder->id)
                ->get('id');

            // Set all children as team_folder = true
            Folder::whereIn('id', Arr::flatten(filter_folders_ids($childrenFolderIds)))
                ->update(['team_folder' => $isTeamFolder]);
            
            DB::commit();
        } catch (\Exception $e) {
            throw (new SetTeamFolderPropertyForAllChildrenException())->debug($e);
        }
        
    }
}
