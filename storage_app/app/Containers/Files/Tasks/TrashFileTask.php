<?php

namespace App\Containers\Files\Tasks;

use Gate;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Files\Models\File;
use App\Containers\Share\Models\Share;
use App\Containers\Files\Exceptions\FileTrashException;

/**
 * Class TrashFileTask.
 *
 */
class TrashFileTask extends Task
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
            // Get file
            $file = File::where('uuid', $uuid)->first();
            
            if (! $file) {
                return;
            }

            // Get folder shared record
            $shared = Share::where('type', 'file')
                ->where('item_id', $file->id)
                ->first();
    
            Gate::authorize('can-edit', [$file, $shared]);

            // Delete file shared record
            if ($shared) {
                $shared->delete();
            }


            $file->delete();
            
            DB::commit();
        } catch (\Exception $e) {
            throw (new FileTrashException())->debug($e);
        }

        return true;
    }
}
