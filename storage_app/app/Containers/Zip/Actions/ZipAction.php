<?php

namespace App\Containers\Zip\Actions;

use App\Abstracts\Action;
use App\Containers\Files\Models\File;
use App\Containers\Zip\Tasks\ZipTask;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use Illuminate\Support\Facades\Validator;
use App\Containers\Traffic\Actions\RecordDownloadAction;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemAction;

/**
 * Class ZipAction.
 *
 */
class ZipAction extends Action
{
    /**
     * @var  \App\Containers\Zip\Tasks\ZipTask
     */
    private $zipTask;

    /**
     * GetFileAction constructor.
     *
     * @param \App\Containers\Zip\Tasks\ZipTask     $zipTask
     */
    public function __construct(
        public ProtectShareRecordAction $protectShareRecord,
        public VerifyAccessToItemAction $verifyAccessToItem,
            ZipTask $zipTask, 
            private RecordDownloadAction $recordDownload)
    {
        $this->zipTask = $zipTask;

    }
    
    /**
     * @param $request
     * @param $shared
     *
     * @return mixed
     */
    public function run($request, ?Share $shared = null)
    {
        $items = extractItemsFromGetAttribute($request->get('items'));
        
        // Validate items GET attribute
        Validator::make(['items' => $items->toArray()], [
            'items'        => 'array',
            'items.*.uuid'   => 'required|uuid',
            'items.*.type' => 'required|string',
        ])->validate();

        // Get list of folders and files from requested url parameter
        $folderIds = $items
            ->where('type', 'folder')
            ->pluck('uuid');

        $fileIds = $items
            ->where('type', 'file')
            ->pluck('uuid');

        $folders = Folder::query()
            ->whereIn('uuid', $folderIds)
            ->get();

        $files = File::query()
            ->whereIn('uuid', $fileIds)
            ->get();
    
        if(!empty($shared->uuid)){
            // Check access to requested folders
            if ($folders->isNotEmpty()) {
                $folders->each(
                    fn ($folder) => ($this->verifyAccessToItem)($folder->id, $shared)
                );
            }

            // Check access to requested files
            if ($files->isNotEmpty()) {

                $file_parent_folders = File::whereUserId($shared->user_id)
                    ->whereIn('id', $files->pluck('id'))
                    ->get()
                    ->pluck('parent_folder_id')
                    ->toArray();

                // Check access to requested directory
                ($this->verifyAccessToItem)($file_parent_folders, $shared);
            }
        }
        
        // Zip items
        $zip = $this->zipTask->run($folders, $files, $shared);
        
        if(!empty(auth()->id())){
            $recordUserId = auth()->id();
        } elseif(!empty($folders->first()->user_id)) {
            $recordUserId = $folders->first()->user_id;
        } elseif(!empty($files->first()->user_id)){
            $recordUserId = $files->first()->user_id;
        }
        
        ($this->recordDownload)(
            $zip->predictZipSize(),
            $recordUserId
        );

        return $zip;
    }
}
