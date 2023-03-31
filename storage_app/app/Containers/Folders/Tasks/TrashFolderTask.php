<?php

namespace App\Containers\Folders\Tasks;

use Gate;
use App\Abstracts\Action;
use Illuminate\Support\Facades\DB;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Exceptions\FolderTrashException;

/**
 * Class TrashFolderTask.
 *
 */
class TrashFolderTask extends Action
{

    /**
     * @param $uuid
     *
     * @return bool
     */
    public function run($uuid)
    {
        try {
            DB::beginTransaction();
            // Get folder
            $folder = Folder::with('folders')
                ->where('uuid', $uuid)->first();

            if (! $folder) {
                return;
            }

            // Get folder shared record
            $shared = Share::where('type', 'folder')
                ->where('item_id', $folder->id)
                ->first();
    
            Gate::authorize('can-edit', [$folder, $shared]);

            // Delete folder shared record
            if ($shared) {
                $shared->delete();
            }

            $folder->delete();
            
            DB::commit();
        } catch (\Exception $e) {
            throw (new FolderTrashException())->debug($e);
        }

        return true;
    }
}
