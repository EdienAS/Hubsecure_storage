<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Folders\Models\Folder;
use App\Containers\Files\Tasks\UpdateFileTask;
use App\Containers\Folders\Tasks\UpdateFolderTask;
use App\Containers\Share\Actions\ProtectShareRecordAction;

/**
 * Class PublicMoveSharedItemAction.
 *
 */
class PublicMoveSharedItemAction extends Action
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
    public function run($request, $shared)
    {
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

        foreach ($request->input('items') as $item) {
            if ($item['type'] === 'folder') {
                $folder = Folder::where('id', $item['id'])
                    ->where('user_id', $shared->user_id)
                    ->firstOrFail();
                ($this->verifyAccessToItem)([
                    $request->input('parent_folder_id'), $item['id'],
                ], $shared);
                
                $this->updateFolderTask->run($request->all(), $folder->uuid);
            } else {
                $file = File::where('id', $item['id'])
                    ->where('user_id', $shared->user_id)
                    ->firstOrFail();

                ($this->verifyAccessToItem)([
                    $request->input('parent_folder_id'), $file->parent_folder_id,
                ], $shared);
                
                $this->updateFileTask->run($request->all(), $file->uuid);
            }

        }
            
        return true; 
    }
}
