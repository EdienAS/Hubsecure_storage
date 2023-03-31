<?php

namespace App\Containers\Folders\Tasks;

use Auth;
use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Traits\UniqueItemNameTrait;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Exceptions\FolderFailedException;

/**
 * Class CreateTeamFolderTask.
 *
 */
class CreateTeamFolderTask extends Task
{
    use UniqueItemNameTrait;


    /**
     * @param array $data
     * @param $shared
     *
     * @return folder
     */
    public function run(array $data)
    {
        try {
            
            DB::beginTransaction();

                $folder = Folder::create([
                    'uuid'        => $data['uuid'],
                    'name'        => $this->getUniqueItemName($data['name'], 
                                            'folder', null,
                                            true
                                        ),
                    'user_id'     => Auth::user()->id,
                    'team_folder' => true,
                ]);

            DB::commit();

        } catch (Exception $e) {
            throw (new FolderFailedException())->debug($e);
        }

        return $folder;
    }

}
