<?php

namespace App\Containers\Teams\Tasks;

use Auth;
use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Teams\Models\TeamFolderMember;
use App\Containers\Teams\Exceptions\TeamFolderMemberException;

/**
 * Class CreateTeamFolderMemberTask.
 *
 */
class CreateTeamFolderMemberTask extends Task
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
            
            DB::beginTransaction();

            // Attach owner into members
            TeamFolderMember::updateOrCreate(['parent_folder_id'  => $folder->id,
                    'user_id'    => Auth::user()->id], 
                    ['permission' => 'owner']);
            
            DB::commit();

            return true;
            
        } catch (Exception $e) {
            throw (new TeamFolderMemberException())->debug($e);
        }

    }

}
