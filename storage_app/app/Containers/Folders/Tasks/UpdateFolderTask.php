<?php

namespace App\Containers\Folders\Tasks;

use URL;
use Gate;
use App\Containers\Folders\Exceptions\FolderUpdateFailedException;
use App\Containers\Folders\Models\Folder;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Teams\Tasks\SetTeamFolderPropertyForAllChildrenTask;

/**
 * Class UpdateFolderTask.
 *
 */
class UpdateFolderTask extends Task
{

    public function __construct(
        public SetTeamFolderPropertyForAllChildrenTask $setTeamFolderPropertyForAllChildrenTask,
    ) {
    }

    /**
     * @param array $data
     * @param       $uuid
     *
     * @return mixed
     */
    public function run(array $data, $uuid)
    {
        $folder = Folder::where('uuid', $uuid)->first();
        unset($data['uuid'],$data['items'],$data['shared'],
                $data['type'], $data['id'], $data['_method']);

        // Check permission
        Gate::authorize('can-edit', [$folder, null]);

        if(str_contains(URL::current(), 'move') == true){
        // Determine, if we are moving folder into the team folder or not
        $isTeamFolder = !isset($data['parent_folder_id'])
            ? false
            : Folder::find($data['parent_folder_id'])->getLatestParent()->team_folder;
        
            // Change team_folder mark for all children folders
            ($this->setTeamFolderPropertyForAllChildrenTask)($folder, $isTeamFolder);
        }
        
        try {
            DB::beginTransaction();

            $folder->update($data);

            DB::commit();
        } catch (\Exception $e) {
            throw (new FolderUpdateFailedException())->debug($e);
        }
        return $folder->refresh();
    }
    
}
