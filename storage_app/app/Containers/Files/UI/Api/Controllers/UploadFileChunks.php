<?php
namespace App\Containers\Files\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Files\Actions\UploadChunksAction;
use App\Containers\Files\UI\Api\Requests\UploadChunkRequest;

class UploadFileChunks extends ControllerApi
{
    /**
     * Upload file for authenticated master|editor user
     *
     */
    public function uploadChunks(
        UploadChunkRequest $request, UploadChunksAction $action
    ) {
        return $action->run($request);
        
    }
}
