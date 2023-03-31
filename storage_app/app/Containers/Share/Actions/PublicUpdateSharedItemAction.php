<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Tasks\UpdateFileTask;
use App\Containers\Folders\Tasks\UpdateFolderTask;
use App\Containers\Share\Actions\ProtectShareRecordAction;

/**
 * Class PublicUpdateSharedItemAction.
 *
 */
class PublicUpdateSharedItemAction extends Action
{
    
    /**
     * @var  \App\Containers\Folders\Tasks\UpdateFolderTask
     */
    private $updateFolderTask;

    /**
     * @var  \App\Containers\Files\Tasks\UpdateFileTask
     */
    private $updateFileTask;

    /**
     * PublicMoveSharedItemAction constructor.
     *
     * @param App\Containers\Share\Actions\ProtectShareRecordAction     $protectShareRecord
     * @param App\Containers\Share\Actions\VerifyAccessToItemAction     $verifyAccessToItem
     * @param \App\Containers\Folders\Tasks\UpdateFolderTask     $updateFolderTask
     * @param \App\Containers\Files\Tasks\UpdateFileTask     $updateFileTask
     */
    
    public function __construct(
        private ProtectShareRecordAction $protectShareRecord,
        private VerifyAccessToItemAction $verifyAccessToItem,
            UpdateFolderTask $updateFolderTask,
            UpdateFileTask $updateFileTask
    ) {
        $this->updateFolderTask = $updateFolderTask;
        $this->updateFileTask = $updateFileTask;
    }
    /**
     * @param $request
     * @param $shared
     *
     * @return boolean
     */
    public function run($request, $id, $shared)
    {
        
        // Check ability to access protected share files
        ($this->protectShareRecord)($shared);
        
        // Check shared permission
        if (is_visitor($shared)) {
            return abort(403, 'Unauthorized action.');
        }

        // Get file|folder item
        $item = get_item_by_id($request->input('type'), $id);
        
        // Check access to requested item
        if ($request->input('type') === 'folder') {
            
            // Check access to requested item
            ($this->verifyAccessToItem)($item->id, $shared);
            
            // Update folder
            return $this->updateFolderTask->run($request->all(), $item->uuid);
        } else {
            
            // Check access to requested item
            ($this->verifyAccessToItem)($item->parent_folder_id, $shared);
            
            // Update file
            return $this->updateFileTask->run($request->all(), $item->uuid);
        }
        
    }
}
