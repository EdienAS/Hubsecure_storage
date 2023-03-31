<?php

namespace App\Containers\Folders\Tasks;

use Gate;
use App\Abstracts\Action;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Containers\Files\Models\File;
use App\Containers\Share\Models\Share;
use Illuminate\Support\Facades\Storage;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Exceptions\FolderDestroyException;

/**
 * Class DestroyFolderTask.
 *
 */
class DestroyFolderTask extends Action
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
            $folder = Folder::withTrashed()
                    ->with('folders')
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

            // Get children folder ids
            $child_folders = filter_folders_ids($folder->trashedFolders);

            // Get children files
            $files = File::withTrashed()
                    ->whereIn('parent_folder_id', Arr::flatten([$folder->id, $child_folders]))
                ->get();

            // Remove all children files
            foreach ($files as $file) {
                // Delete file
                Storage::delete("/files/$file->user_id/$file->basename");

                // Delete thumbnail if exist
                if ($file->type === 'image') {
                    getThumbnailFileList($file->basename)
                        ->each(fn ($thumbnail) => Storage::delete("files/$file->user_id/$thumbnail"));
                }

                // Delete file permanently
                $file->forceDelete();
            }

            Folder::whereIn('id', $child_folders)->forceDelete();
            Share::where('type', 'folder')->whereIn('item_id', $child_folders)->delete();
            
            // Delete folder record
            $folder->forceDelete();

            DB::commit();
        } catch (\Exception $e) {
            throw (new FolderDestroyException())->debug($e);
        }
        
        return true;
    }
}
