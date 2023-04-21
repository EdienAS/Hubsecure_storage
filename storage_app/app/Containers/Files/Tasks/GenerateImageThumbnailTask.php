<?php
namespace App\Containers\Files\Tasks;

use App\Traits\StorageDiskTrait;
use Spatie\QueueableAction\QueueableAction;
use Intervention\Image\ImageManagerStatic as Image;

class GenerateImageThumbnailTask
{
    use QueueableAction, StorageDiskTrait;

    public function __invoke($fileName, $userId, $execution)
    {
        try{
            // Get image width
            $imageWidth = getimagesize(
                $this->getStorageDisk()->path("temp/$userId/$fileName")
            )[0];

            collect(config("filemanager.image_sizes.$execution"))
                ->each(function ($size) use ($userId, $fileName, $imageWidth) {
                    if ($imageWidth > $size['size'] || app()->environment() == 'testing') {
                        // Create intervention image
                        $intervention = Image::make(
                            $this->getStorageDisk()->path("temp/$userId/$fileName")
                        )
                            ->orientate();

                        // Generate thumbnail
                        $intervention
                            ->resize($size['size'], null, fn ($constraint) => $constraint->aspectRatio())
                            ->stream();

                        // Store thumbnail to disk
                        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
                        $this->getStorageDisk()->put($temp . "files/$userId/{$size['name']}-$fileName", $intervention);
                    }
                });

            // Delete file after generate a thumbnail
//            if ($execution === 'later') {
                $this->getStorageDisk()->delete("temp/$userId/$fileName");
//            }
        } catch (Exception $e) {
            
            throw (new GenerateImageThumdnailException())->debug($e);
        }

        return true;
    }
}
