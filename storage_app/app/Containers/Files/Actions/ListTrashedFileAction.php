<?php

namespace App\Containers\Files\Actions;

use Auth;
use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Files\Resources\FilesCollection;

/**
 * Class ListTrashedFileAction.
 *
 */
class ListTrashedFileAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run()
    {
        $page = request()->has('page')
            ? request()->input('page')
            : 'all';

        // Prepare folder & file db query
        $query = [
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

        [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries] = getRecordsCount($query, $page, true);

        $files = File::query()->onlyTrashed()->with($query['with']);
        
//            $files->where('parent_folder_id', null);
            
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
            $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
        ])->collapse();
            
        [$paginate, $links] = formatPaginatorMetadata($totalEntries);

        $paginate['limit'] = $request['limit'] ?? null;
        
        return  array(
            'items'  => $entries,
            'links' => $links,
            'meta'  => [
                'paginate' => $paginate,
            ],
        );
    }
}
