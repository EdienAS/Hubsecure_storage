<?php

namespace App\Containers\Files\Actions;

use App\Abstracts\Action;
use App\Abstracts\RequestHttp;
use App\Containers\Share\Models\Share;
use App\Containers\Files\Tasks\UploadFileTask;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemAction;

/**
 * Class UploadFileAction.
 *
 */
class UploadFileAction extends Action
{

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
        UploadFileTask $uploadFileTask,
    ) {
        $this->uploadFileTask = $uploadFileTask;
    }
    
    
    /**
     * @param RequestHttp $request
     * @param bool $login
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
        
        $file = $this->uploadFileTask->run($request);
        
        return array('items' => $file);
        
    }
}
