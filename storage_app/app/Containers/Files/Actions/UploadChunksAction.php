<?php

namespace App\Containers\Files\Actions;

use App\Abstracts\Action;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use App\Abstracts\RequestHttp;
use App\Traits\StorageDiskTrait;
use League\Fractal\Resource\Item;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use App\Containers\Files\Tasks\UploadFileTask;
use App\Containers\Files\Tasks\StoreFileChunksTask;
use App\Containers\Folders\Resources\FolderResource;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemAction;
use App\Containers\Folders\UI\Api\Transformers\FolderTransformer;

/**
 * Class UploadChunksAction.
 *
 */
class UploadChunksAction extends Action
{

    use StorageDiskTrait;
    
    /**
     * @var  UploadFileTask
     */
    private $uploadFileTask;
    
    
    /**
     * UploadFileAction constructor.
     *
     * @param \App\Containers\Files\Tasks\UploadFileTask     $uploadFileTask
     */
    public function __construct(
        public ProtectShareRecordAction $protectShareRecord,
        public VerifyAccessToItemAction $verifyAccessToItem,
        StoreFileChunksTask $storeFileChunksTask,
        UploadFileTask $uploadFileTask, Manager $fractal
    ) {
        $this->storeFileChunksTask = $storeFileChunksTask;
        $this->uploadFileTask = $uploadFileTask;
        $this->fractal = $fractal;
    }
    
    
    /**
     * @param $request
     * @param $shared
     *
     * @return mixed
     */
    public function run($request, ?Share $shared = null)
    {
        if(!empty($shared->uuid)){
            
            // Check ability to access protected share record
            ($this->protectShareRecord)($shared);

            // Check shared permission
            if (is_visitor($shared)) {
                return abort(403, 'Unauthorized action.');
            }

            // Add default parent id if missing
            if ($request->missing('parent_folder_id')) {
                $request->merge(['parent_folder_id' => $shared->item_id]);
            }

            // Check access to requested directory
            ($this->verifyAccessToItem)($request->input('parent_folder_id'), $shared);

        }
        
        // Store file chunks
        $chunkPath = ($this->storeFileChunksTask)($request);
        
        // Proceed after last chunk
        if ($request->boolean('is_last_chunk')) {
            // Get user
            $user = $request->filled('parent_folder_id')
                ? Folder::find($request->input('parent_folder_id'))
                    ->getLatestParent()
                    ->user
                : auth()->user();

            // Get file name
            $name = Str::uuid() . '.' . $request->input('extension');

            // Move file to user directory
            $temp = (app()->environment() == 'testing') ? 'testing/' : null;
            $this->getStorageDisk()->move($chunkPath, $temp . "files/$user->id/$name");

            $uploadChunks = $this->uploadFileTask->run($request);
            $uploadedChunksFolderId = $uploadChunks[0]->parent_folder_id;
            $folderData = Folder::with('files', 'folders')
                    ->whereId($uploadedChunksFolderId)->first();
            
            $data = array('items' => array(new FolderResource($folderData)));
            return $this->fractal->createData(new Item($data, new FolderTransformer()))->toArray();
        }
                
        $response = new Response(null);
        $response->setStatusCode(202);
                
        return $response->withHeaders(array ());
        
    }
}
