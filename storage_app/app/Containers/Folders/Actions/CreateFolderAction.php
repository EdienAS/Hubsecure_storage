<?php

namespace App\Containers\Folders\Actions;

use App\Abstracts\Action;
use App\Abstracts\RequestHttp;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Tasks\CreateFolderTask;
use App\Containers\Folders\Resources\FolderResource;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemAction;

/**
 * Class CreateFolderAction.
 *
 */
class CreateFolderAction extends Action
{

    /**
     * @var  CreateFolderTask
     */
    private $createFolderTask;
    
    
    /**
     * CreateFolderAction constructor.
     *
     * @param \App\Containers\Folder\Tasks\CreateFolderTask     $createFolderTask
     */
    public function __construct(
        public ProtectShareRecordAction $protectShareRecord,
        public VerifyAccessToItemAction $verifyAccessToItem,
        CreateFolderTask $createFolderTask
    ) {
        $this->createFolderTask = $createFolderTask;
    }
    
    
    /**
     * @param $request
     * @param $shared
     *
     * @return folder
     */
    public function run($request, ?Share $shared = null)
    {
        if(!empty($shared->uuid)){

            // Check ability to access protected share files
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
        $data = $request->all();

        $folder = $this->createFolderTask->run($data, $shared);
        
        return array('items' => array(new FolderResource($folder)));
    }
}
