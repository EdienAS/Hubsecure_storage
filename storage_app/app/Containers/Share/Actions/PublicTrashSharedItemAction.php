<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Tasks\TrashFileTask;
use App\Containers\Folders\Tasks\TrashFolderTask;
use App\Containers\Share\Actions\ProtectShareRecordAction;

/**
 * Class PublicTrashSharedItemAction.
 *
 */
class PublicTrashSharedItemAction extends Action
{
    
    /**
     * @var  \App\Containers\Folders\Tasks\UpdateFolderTask
     */
    private $trashFolderTask;

    /**
     * @var  \App\Containers\Files\Tasks\UpdateFileTask
     */
    private $trashFileTask;

    /**
     * PublicMoveSharedItemAction constructor.
     *
     * @param App\Containers\Share\Actions\ProtectShareRecordAction     $protectShareRecord
     * @param App\Containers\Share\Actions\VerifyAccessToItemAction     $verifyAccessToItem
     * @param \App\Containers\Folders\Tasks\TrashFolderTask     $trashFolderTask
     * @param \App\Containers\Files\Tasks\TrashFileTask     $trashFileTask
     */
    
    public function __construct(
        private ProtectShareRecordAction $protectShareRecord,
        private VerifyAccessToItemAction $verifyAccessToItem,
            TrashFolderTask $trashFolderTask,
            TrashFileTask $trashFileTask
    ) {
        $this->trashFolderTask = $trashFolderTask;
        $this->trashFileTask = $trashFileTask;
    }
    /**
     * @param $request
     * @param $shared
     *
     * @return boolean
     */
    public function run($request, $shared)
    {
        // Check ability to access protected share files
        ($this->protectShareRecord)($shared);
        
        // Check shared permission
        if (is_visitor($shared)) {
            return abort(403, 'Unauthorized action.');
        }

        foreach ($request->input('items') as $requestItem) {
            // Get file|folder item
            $item = get_item_by_id($requestItem['type'], $requestItem['id']);

            if ($requestItem['type'] === 'folder') {
                // Check access to requested item
                ($this->verifyAccessToItem)($item->id, $shared);
                
                //Trash folder
                $this->trashFolderTask->run($item->uuid);
            } else {
                
                // Check access to requested item
                ($this->verifyAccessToItem)($item->parent_folder_id, $shared);
                
                //Trash file
                $this->trashFileTask->run($item->uuid);
            }

        }
        
        return true;
    }
}
