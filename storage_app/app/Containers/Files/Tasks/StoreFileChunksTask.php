<?php
namespace App\Containers\Files\Tasks;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use App\Containers\Files\UI\Api\Requests\UploadChunkRequest;
use App\Containers\Share\UI\Api\Requests\PublicUploadChunksSharedItemRequest;

class StoreFileChunksTask
{
    /**
     * @throws FileNotFoundException
     */
    public function __invoke(UploadChunkRequest|PublicUploadChunksSharedItemRequest $request)
    {
        
        try {

            // Get uploaded file
            $file = $request->file('files')[0];
            
            // Get chunk name
            $name = $file->getClientOriginalName();

            // Get chunk file path
            $path = Storage::disk('public')->path("chunks/$name");

            // Build the file
            File::append($path, $file->get());

            // If last chunk, then return file path
            if ($request->boolean('is_last_chunk')) {
                return "chunks/$name";
            }
        } catch (Exception $e) {
            
            throw (new StoreFileChunksException())->debug($e);
        }
    }
}
