<?php

namespace App\Containers\Share\Actions;

use Gate;
use App\Abstracts\Action;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App\Containers\Files\Models\File;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use App\Containers\Zip\Actions\ZipAction;
use App\Containers\Files\Resources\FileResource;
use App\Containers\Files\Tasks\DownloadFileTask;
use App\Containers\Files\Resources\FilesCollection;
use App\Containers\Folders\Resources\FolderResource;
use App\Containers\Folders\Resources\FolderCollection;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemWithinAction;
use App\Containers\Files\UI\Api\Transformers\FilePublicTransformer;
use App\Containers\Folders\UI\Api\Transformers\FolderPublicTransformer;

/**
 * Class PublicGetSharedItemAction.
 *
 */
class PublicGetSharedItemAction extends Action
{
    
    public function __construct(
        private DownloadFileTask $downloadFileTask,
        private ProtectShareRecordAction $protectShareRecord,
        private VerifyAccessToItemWithinAction $verifyAccessToItemWithin,
        private VerifyAccessToItemAction $verifyAccessToItem,
            Manager $fractal,
            ZipAction $zipAction
    ) {
        $this->fractal = $fractal;
        $this->zipAction = $zipAction;
    }
    /**
     * @param $request
     * @param $share
     *
     * @return boolean
     */
    public function run($request)
    {
        $shared = Share::where('token',$request['token'])->first();

        // Check ability to access protected share files
        ($this->protectShareRecord)($shared);
        
        if($shared->type === 'file'){
            // Get file record
            $file = File::where('user_id', $shared->user_id)
                ->where('id', $shared->item_id)
                ->firstOrFail();

            Gate::authorize('can-view', [$file, $shared]);

            // Set access urls
            $file->setSharedPublicUrl($shared->token);

            // Check file access
            ($this->verifyAccessToItemWithin)($shared, $file);

            if($request->get('download') == true){
                return $this->downloadFileTask->run($file);
            } else {
                return $this->fractal->createData(new Item(array('items' => array(new FileResource($file))), new FilePublicTransformer()))->toArray();
            }
        } else {
            // Check if user can get directory
            ($this->verifyAccessToItem)($shared->item_id, $shared);

            if(!empty($request->get('folderUuid'))){
                $folder = Folder::with('files', 'folders')
                        ->where('uuid', $request->get('folderUuid'))->first();
            } else {
                $folder = Folder::where('id', $shared->item_id)
                        ->with('files', 'folders')->first();
            }
            
            $folderId = $folder->id;
            // Get requested folder
            $requestedFolder = Folder::findOrFail($folderId);

            $page = request()->has('page')
                ? request()->input('page')
                : 'all';

            // Prepare folder & file db query
            $query = [
                'folder' => [
                    'where' => [
                        'parent_folder_id'   => $folderId,
                        'user_id'     => $shared->user_id,
                    ],
                ],
                'file' => [
                    'where' => [
                        'parent_folder_id'   => $folderId,
                        'user_id'     => $shared->user_id,
                    ],
                ],
            ];

            [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries] = getRecordsCount($query, $page);

            $folders = Folder::query();

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

            $files = File::query();

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

            // Set thumbnail links for public files
            $files->map(fn ($file) => $file->setSharedPublicUrl($shared->token));

            $entries = collect([
                $folders ? json_decode((new FolderCollection($folders))->toJson(), true) : null,
                $files ? json_decode((new FilesCollection($files))->toJson(), true) : null,
            ])->collapse();

            [$paginate, $links] = formatPaginatorMetadata($totalEntries);

            $paginate['limit'] = $request['limit'] ?? null;

            $finalData = array(
                'items'  => $entries,
                'links' => $links,
                'meta'  => [
                    'paginate' => $paginate,
                    'root'     => new FolderResource($requestedFolder),
                ],
            );
            
            
            if($request->get('download') == true){
                $request->request->add(['items' => $folder->uuid . '|folder']);

                return $this->zipAction->run($request);
            } else {
                return $this->fractal->createData(new Item($finalData, new FolderPublicTransformer()))->toArray();
            }
        }
    }
}
