<?php

namespace App\Containers\Browse\Actions;

use Str;
use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Folders\Models\Folder;
use App\Containers\Files\Resources\FilesCollection;
use App\Containers\Folders\Resources\FolderResource;
use App\Containers\Folders\Resources\FolderCollection;

/**
 * Class BrowseTrashAction.
 *
 */
class BrowseTrashAction extends Action
{
    
    
    /**
     * @param $uuid
     *
     * @return mixed
     */
    public function run($uuid)
    {
        $rootId = Str::isUuid($uuid)
            ? Folder::where('uuid', $uuid)->pluck('id')->first()
            : null;

        $page = request()->has('page')
            ? request()->input('page')
            : 'all';

        // Prepare folder & file db query
        $query = [
            'folder' => [
                'where' => [
                    'user_id'     => auth()->id(),
                ],
            ],
            'file' => [
                'where' => [
                    'user_id'     => auth()->id(),
                ],
            ],
            'with' => [
                'parent:id,uuid,name',
                'shared:token,id,item_id,permission,is_protected,expire_in',
            ],
        ];

        [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries] = getRecordsCount($query, $page);

        $folders = Folder::onlyTrashed()->with($query['with'])
            ->where($query['folder']['where'])
            ->sortable()
            ->skip($foldersSkip)
            ->take($foldersTake)
            ->get();
        
        $files = File::onlyTrashed()->with($query['with'], 'creator', 'exif')
            ->where($query['file']['where'])
            ->sortable()
            ->skip($filesSkip)
            ->take($filesTake)
            ->get();
        
        $entries = collect([
            $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
            $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
        ])->collapse();
            
        [$paginate, $links] = formatPaginatorMetadata($totalEntries);

        return array(
            'items'  => $entries,
            'links' => $links,
            'meta'  => [
                'paginate' => $paginate,
                'root'     => $rootId ? new FolderResource(Folder::findOrFail($rootId)) : null,
            ],
        );
    }
}
