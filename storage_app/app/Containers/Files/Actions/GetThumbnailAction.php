<?php

namespace App\Containers\Files\Actions;

use Gate;
use App\Abstracts\Action;
use App\Containers\Files\Tasks\GetThumbnailTask;
use App\Containers\Files\Tasks\DownloadThumbnailTask;

/**
 * Class GetThumbnailAction.
 *
 */
class GetThumbnailAction extends Action
{
    /**
     * @var  \App\Containers\Files\Tasks\GetThumbnailTask
     */
    private $getThumbnailTask;

    /**
     * GetThumbnailAction constructor.
     *
     * @param \App\Containers\Files\Tasks\GetThumbnailTask     $getThumbnailTask
     * @param \App\Containers\Files\Tasks\DownloadThumbnailTask     $downloadThumbnailTask
     */
    public function __construct(GetThumbnailTask $getThumbnailTask, DownloadThumbnailTask $downloadThumbnailTask)
    {
        $this->getThumbnailTask = $getThumbnailTask;
        
        $this->downloadThumbnailTask = $downloadThumbnailTask;

    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        
        $file = $this->getThumbnailTask->run($request->name);
        
        // Check if user has privileges to download file
        if (! Gate::any(['can-edit', 'can-view'], [$file, null])) {
            return response()->json(accessDeniedError(), 403);
        }

        return ($this->downloadThumbnailTask)($request->name, $file);
        
    }
}
