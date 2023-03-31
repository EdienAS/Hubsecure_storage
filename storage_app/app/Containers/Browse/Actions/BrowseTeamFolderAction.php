<?php

namespace App\Containers\Browse\Actions;

use DB;
use Gate;
use App\Abstracts\Action;
use Illuminate\Support\Str;
use App\Containers\Files\Models\File;
use App\Containers\Folders\Models\Folder;
use App\Containers\Files\Resources\FilesCollection;
use App\Containers\Folders\Resources\FolderResource;
use App\Containers\Folders\Resources\FolderCollection;

/**
 * Class BrowseTeamFolderAction.
 *
 */
class BrowseTeamFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($uuid)
    {
        // Get root ID
        $id = Str::isUuid($uuid)
            ? Folder::where('uuid', $uuid)
                    ->where('team_folder', true)->pluck('id')->first()
            : null;

        // Get page number
        $page = request()->has('page')
            ? request()->input('page')
            : 'all';

        $entriesPerPage = config('filemanager.paginate.perPage');

        if ($id) {
            // Get team folder
            $teamFolder = Folder::findOrFail($id)
                    ->getLatestParent();

            // Check privileges
            if (! Gate::any(['can-edit', 'can-view'], [$teamFolder, null])) {
                return abort(403, 'Unauthorized action.');
            }

            $query = [
                'folder' => [
                    'where' => [
                        'parent_folder_id'   => $id,
                        'team_folder' => true,
                    ],
                ],
                'file' => [
                    'where' => [
                        'parent_folder_id'   => $id,
                    ],
                ],
                'with' => [
                    'parent:id,uuid,name',
                    'shared:token,id,item_id,permission,is_protected,expire_in',
                ],
            ];

            [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries] = getRecordsCount($query, $page);

            $folders = Folder::with($query['with'])
                ->where($query['folder']['where'])
                ->sortable()
                ->skip($foldersSkip)
                ->take($foldersTake)
                ->get();

            $files = File::with($query['with'])
                ->where($query['file']['where'])
                ->sortable()
                ->skip($filesSkip)
                ->take($filesTake)
                ->get();
        }

        if (! $id) {
            $folders = Folder::where('parent_folder_id', null)
                ->where('team_folder', true)
                ->where('user_id', auth()->id())
                ->sortable()
                ->skip($entriesPerPage * ($page - 1))
                ->take($entriesPerPage)
                ->get();

            $totalEntries = DB::table('folders')
                ->where('parent_folder_id', null)
                ->where('team_folder', true)
                ->where('user_id', auth()->id())
                ->count();

            $files = null;
        }

        [$paginate, $links] = formatPaginatorMetadata($totalEntries);

        $entries = collect([
            $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
            $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
        ])->collapse();

        // Collect folders and files to single array
        return array(
            'items'       => $entries,
            'links'      => $links,
            'meta'       => [
                'paginate'   => $paginate,
                'teamFolder' => $id
                    ? new FolderResource($teamFolder)
                    : null,
                'root'       => $id
                    ? new FolderResource(Folder::findOrFail($id))
                    : null,
            ],
        );
    }
}
