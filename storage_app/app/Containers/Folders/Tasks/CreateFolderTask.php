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
 * Class CreateFolderTask.
 *
 */
class CreateFolderTask extends Task
{
    use UniqueItemNameTrait;


    /**
     * @param array $data
     * @param $shared
     *
     * @return folder
     */
    public function run(array $data,
        $shared = null)
    {
        try {
            
            // Get stuff
            $isFilledParentFolderId = isset($data['parent_folder_id']) ? true : false;
            $parentFolderId = isset($data['parent_folder_id']) ? $data['parent_folder_id'] : null;
            
            // Get user
            $user = $isFilledParentFolderId
                ? Folder::find($parentFolderId)->getLatestParent()->user
                : Auth::user();

            DB::beginTransaction();
            
                $folder = Folder::create([
                    'uuid'        => $data['uuid'],
                    'parent_folder_id'   => $parentFolderId,
                    'name'        => $this->getUniqueItemName($data['name'], 
                                            'folder', $parentFolderId,
                                            $isFilledParentFolderId
                                        ),
                    'color'       => $data['color'] ?? null,
                    'emoji'       => $data['emoji'] ?? null,
                    'author_id'   => $shared ? 3 : 1,
                    'user_id'     => $user->id,
                    'team_folder' => $isFilledParentFolderId
                        ? Folder::find($parentFolderId)->getLatestParent()->team_folder
                        : false,
                ]);

            DB::commit();

        } catch (Exception $e) {
            throw (new FolderFailedException())->debug($e);
        }

        return $folder;
    }

}
