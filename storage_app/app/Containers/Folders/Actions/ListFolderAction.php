<?php

namespace App\Containers\Folders\Actions;

use App\Abstracts\Action;
use App\Containers\Folders\Models\Folder;
use App\Containers\Folders\Resources\FolderCollection;

/**
 * Class ListFolderAction.
 *
 */
class ListFolderAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $page = request()->has('page')
            ? request()->input('page')
            : 'all';

        // Prepare folder & file db query
        $query = [
            'folder' => [
                'where' => [
                    'team_folder' => false,
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
        
        $entries = collect([
            $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
        ])->collapse();
            
        [$paginate, $links] = formatPaginatorMetadata($totalEntries);

        $paginate['limit'] = $request['limit'] ?? null;
        
        return array(
            'items'  => $entries,
            'links' => $links,
            'meta'  => [
                'paginate' => $paginate,
            ],
        );
    }
}
