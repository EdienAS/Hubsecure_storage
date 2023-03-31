<?php

namespace App\Containers\Teams\Tasks;

use Gate;
use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Teams\Models\TeamFolderMember;
use App\Containers\Teams\Exceptions\TeamFolderMemberException;

/**
 * Class DestroyTeamFolderMemberTask.
 *
 */
class DestroyTeamFolderMemberTask extends Task
{

    /**
     * @param array $data
     * @param $folder
     *
     * @return folder
     */
    public function run($folder)
    {
        try {

            // Authorize action
            if (! Gate::any(['can-edit', 'can-view'], [$folder, null])) {
                abort(403, 'You are not member of this team folder.');
            }

            DB::beginTransaction();

            // Attach owner into members
            TeamFolderMember::where('parent_folder_id', $folder->id)
                ->where('user_id', auth()->id())
                ->delete();
            
            DB::commit();

            return true;
            
        } catch (Exception $e) {
            throw (new TeamFolderMemberException())->debug($e);
        }

    }

}
