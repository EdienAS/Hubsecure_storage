<?php

namespace App\Containers\Files\Tasks;

use App\Containers\Files\Exceptions\GetFileFailedException;
use App\Containers\Files\Models\File;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Traffic\Actions\RecordDownloadAction;

/**
 * Class GetFileTask.
 *
 */
class GetFileTask extends Task
{
    public function __construct(
        private RecordDownloadAction $recordDownload,
    ) {
    }
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        try {
            DB::beginTransaction();

            $file = File::withTrashed()
            ->where('basename', $request->basename)
            ->firstOrFail();
            DB::commit();
          
        } catch (\Exception $e) {
            throw (new GetFileFailedException())->debug($e);
        }
        return $file;
    }
    
}
