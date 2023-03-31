<?php

namespace App\Containers\Search\Actions;

use DB;
use Arr;
use Auth;
use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Folders\Models\Folder;
use App\Containers\Files\Resources\FilesCollection;
use App\Containers\Folders\Resources\FolderCollection;

/**
 * Class SearchFileFolderAction.
 *
 */
class SearchFileFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        // Prepare queries
        $query = remove_accents(
            $request->input('query')
        );
        
        $user_id = Auth::id();

        // Get "shared with me" folders
        $sharedWithMeFolderIds = DB::table('team_folder_members')
            ->where('user_id', $user_id)
            ->pluck('parent_folder_id');

        // Next get their folder tree for ids extraction
        $folderWithinIds = Folder::with('folders:id,parent_folder_id')
            ->whereIn('parent_folder_id', $sharedWithMeFolderIds)
            ->get(['id']);

        // Then get all accessible shared folders within
        $accessible_parent_folder_ids = Arr::flatten([filter_folders_ids($folderWithinIds), $sharedWithMeFolderIds]);

        // Prepare eloquent builder
        $folder = new Folder();
        $file = new File();

        // Prepare folders constrain
        $folderConstrain = $folder
            ->where('user_id', $user_id)
            ->orWhereIn('id', $accessible_parent_folder_ids);

        // Prepare files constrain
        $fileConstrain = $file
            ->where('user_id', $user_id)
            ->orWhereIn('parent_folder_id', $accessible_parent_folder_ids);

        // Search files and folders
        $files = File::search($query)
            ->get()
            ->take(3);

        $folders = Folder::search($query)
            ->get()
            ->take(3);

        $entries = collect([
            $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
            $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
        ])->collapse();

        // Collect folders and files to single array
        return array(
            'items' => $entries,
        );
    }
}
