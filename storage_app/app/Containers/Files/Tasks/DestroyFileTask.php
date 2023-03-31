<?php

namespace App\Containers\Files\Tasks;

use Gate;
use Config;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Containers\User\Models\User;
use App\Containers\Files\Models\File;
use App\Containers\Share\Models\Share;
use Illuminate\Support\Facades\Storage;
use App\Containers\Traffic\Models\Traffic;
use App\Containers\UserSettings\Models\Usersetting;
use App\Containers\Files\Exceptions\FileDestroyException;


/**
 * Class DestroyFileTask.
 *
 */
class DestroyFileTask extends Task
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
            $file = File::withTrashed()
                    ->where('uuid', $uuid)->first();

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

            $user = User::find($file->user_id);

            switch($file->file_storage_option_id){
                case 1:
                    // Delete file
                    Storage::delete("/files/$file->user_id/$file->basename");

                    // Delete thumbnail if exist
                    if ($file->type === 'image') {
                        getThumbnailFileList($file->basename)
                            ->each(fn ($thumbnail) => Storage::delete("files/$file->user_id/$thumbnail"));
                    }

                    break;
                default:
                    break;
            }
            
            Traffic::where('user_id', $file->user_id)
                    ->whereDate('created_at', $file->created_at)
                    ->decrement('upload', $file->filesize);
            
            // Delete file permanently
            $file->forceDelete();
            
            
            DB::commit();
        } catch (\Exception $e) {
            throw (new FileDestroyException())->debug($e);
        }

        return true;
    }
}
