<?php

namespace App\Containers\Files\Tasks;

use Exception;
use App\Abstracts\Task;
use App\Traits\StorageDiskTrait;
use App\Containers\Files\Exceptions\ProcessImageThumdnailException;

/**
 * Class ProcessImageThumbnailTask.
 *
 */
class ProcessImageThumbnailTask extends Task
{
    use StorageDiskTrait;

    public function __construct(
        public GenerateImageThumbnailTask $generateImageThumbnailTask,
    ) {
    }

    private array $availableFormats = [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    /**
     * @param string $name
     * @param integers  $userId
     *
     * @return mixed
     */
    public function run($name, $userId)
    {
        try {
            
            // Get local disk instance
            $disk = $this->getStorageDisk();

            $temp = (app()->environment() == 'testing') ? 'testing/' : null;
            if (! in_array($disk->mimeType($temp . "files/$userId/$name"), $this->availableFormats)) {
                return;
            }

            // Make copy of file for the thumbnail generation
            $disk->copy($temp . "files/$userId/$name", "temp/$userId/$name");

            // Create thumbnails instantly
            ($this->generateImageThumbnailTask)(
                fileName: $name,
                userId: $userId,
                execution: 'immediately'
            );

//            // Create thumbnails later
//            ($this->generateImageThumbnailTask)
//                ->onQueue('high')
//                ->execute(
//                    fileName: $name,
//                    userId: $userId,
//                    execution: 'later'
//            );
           
        } catch (Exception $e) {
            throw (new ProcessImageThumdnailException())->debug($e);
        }

        return true;
    }
}
