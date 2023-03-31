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
 * Class BrowseFolderAction.
 *
 */
class BrowseFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $uuid = $request->uuid ?? null;
        
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
                    'parent_folder_id'   => $rootId,
                    'team_folder' => false,
                    'user_id'     => auth()->id(),
                    'deleted_at'  => null,
                ],
            ],
            'file' => [
                'where' => [
                    'parent_folder_id'   => $rootId,
                    'user_id'     => auth()->id(),
                    'deleted_at'  => null,
                ],
            ],
            'with' => [
                'parent:id,uuid,name',
                'shared:token,id,item_id,permission,is_protected,expire_in',
            ],
        ];

        [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries] = getRecordsCount($query, $page);

        $folders = Folder::query()->with($query['with']);
        
        if(!empty($request['orderBy']) && in_array($request['orderBy'], ['asc','desc'])){
            $folders->orderBy('created_at', $request['orderBy']);
        }

        if(!empty($request['limit']) && in_array($request['limit'], range( 1, 10 ))){
            $folders->limit($request['limit']);
        } else {
            $folders->take($foldersTake);
        }
        
        $folders = $folders->where($query['folder']['where'])
            ->sortable()
            ->skip($foldersSkip)
            ->get();
        
        $files = File::query()->with($query['with'], 'creator', 'exif');
        
        if(!empty($request['orderBy']) && in_array($request['orderBy'], ['asc','desc'])){
            $files->orderBy('created_at', $request['orderBy']);
        }

        if(!empty($request['limit']) && in_array($request['limit'], range( 1, 10 ))){
            $files->limit($request['limit']);
        } else {
            $files->take($filesTake);
        }
        
        $files = $files->where($query['file']['where'])
            ->sortable()
            ->skip($filesSkip)
            ->get();
        
        $entries = collect([
            $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
            $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
        ])->collapse();
            
        [$paginate, $links] = formatPaginatorMetadata($totalEntries);

        $paginate['limit'] = $request['limit'] ?? null;
        
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
