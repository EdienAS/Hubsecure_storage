<?php

namespace App\Containers\Files\Tasks;

use App\Containers\Files\Exceptions\GetFileFailedException;
use App\Containers\Files\Models\File;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Traffic\Actions\RecordDownloadAction;

/**
 * Class GetThumbnailTask.
 *
 */
class GetThumbnailTask extends Task
{
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($filename)
    {
        try {
            DB::beginTransaction();

            $file = File::withTrashed()
            ->where('basename', substr($filename, 3))
            ->firstOrFail();
            DB::commit();
          
        } catch (\Exception $e) {
            throw (new GetFileFailedException())->debug($e);
        }
        return $file;
    }
    
}
