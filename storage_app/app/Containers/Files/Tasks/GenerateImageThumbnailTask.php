<?php
namespace App\Containers\Files\Tasks;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Intervention\Image\ImageManagerStatic as Image;

class GenerateImageThumbnailTask
{
    use QueueableAction;

    public function __invoke($fileName, $userId, $execution)
    {
        try{
            // Get image width
            $imageWidth = getimagesize(
                Storage::disk('public')->path("temp/$userId/$fileName")
            )[0];

            collect(config("filemanager.image_sizes.$execution"))
                ->each(function ($size) use ($userId, $fileName, $imageWidth) {
                    if ($imageWidth > $size['size']) {
                        // Create intervention image
                        $intervention = Image::make(
                            Storage::disk('public')->path("temp/$userId/$fileName")
                        )
                            ->orientate();

                        // Generate thumbnail
                        $intervention
                            ->resize($size['size'], null, fn ($constraint) => $constraint->aspectRatio())
                            ->stream();

                        // Store thumbnail to disk
                        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
                        Storage::put($temp . "files/$userId/{$size['name']}-$fileName", $intervention);
                    }
                });

            // Delete file after generate a thumbnail
//            if ($execution === 'later') {
                Storage::disk('public')->delete("temp/$userId/$fileName");
//            }
        } catch (Exception $e) {
            
            throw (new GenerateImageThumdnailException())->debug($e);
        }

        return true;
    }
}
