<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Share\Models\Share;
use App\Containers\Files\Tasks\GetThumbnailTask;
use App\Containers\Files\Tasks\DownloadThumbnailTask;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Containers\Traffic\Actions\RecordDownloadAction;
use App\Containers\Share\Actions\ProtectShareRecordAction;
use App\Containers\Share\Actions\VerifyAccessToItemWithinAction;

/**
 * Class PublicGetThumbnailSharedItemAction.
 *
 */
class PublicGetThumbnailSharedItemAction extends Action
{
    
    public function __construct(
        private RecordDownloadAction $recordDownload,
        private ProtectShareRecordAction $protectShareRecord,
        private VerifyAccessToItemWithinAction $verifyAccessToItemWithin, 
        GetThumbnailTask $getThumbnailTask,
        DownloadThumbnailTask $downloadThumbnailTask
    ) {
        
        $this->getThumbnailTask = $getThumbnailTask;
        
        $this->downloadThumbnailTask = $downloadThumbnailTask;
    }
    
    /**
     * @throws FileNotFoundException
     */
    public function run(
        $filename,
        Share $shared,
    ): StreamedResponse {
        
        // Check ability to access protected share files
        ($this->protectShareRecord)($shared);

        // Get file record
        $file = $this->getThumbnailTask->run($filename);
        
        // Check file access
        ($this->verifyAccessToItemWithin)($shared, $file);

        // Store user download size
        ($this->recordDownload)(
            file_size: $file->filesize,
            user_id: $shared->user_id,
        );

        // Finally, download thumbnail
        return ($this->downloadThumbnailTask)($filename, $file);
    }
}
