<?php

namespace App\Containers\Files\Tasks;

use App\Abstracts\Task;
use App\Traits\StorageDiskTrait;
use App\Containers\Files\Models\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Containers\Files\Exceptions\FileNotFoundException;

/**
 * Class DownloadThumbnailTask.
 *
 */
class DownloadThumbnailTask extends Task
{
    use StorageDiskTrait;
    /**
     * Get image thumbnail for browser
     *
     * @throws FileNotFoundException
     */
    public function __invoke(
        string $filename,
        File $file
    ): StreamedResponse {
        // Get file path
        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
        $filePath = $temp . "/files/$file->user_id/$filename";

        // Check if file exist
        if (! $this->getStorageDisk()->exists($filePath)) {
            // Get original file path
            $substituteFilePath = $temp . "/files/$file->user_id/$file->basename";

            // Check if original file exist
            if (! $this->getStorageDisk()->exists($substituteFilePath)) {
                throw new FileNotFoundException();
            }

            // Return image thumbnail
            return $this->getStorageDisk()->download($substituteFilePath, $filename);
        }

        // Return image thumbnail
        return $this->getStorageDisk()->download($filePath, $filename);
    }
    
}
