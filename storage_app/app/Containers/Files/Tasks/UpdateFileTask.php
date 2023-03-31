<?php

namespace App\Containers\Files\Tasks;

use Gate;
use App\Containers\Files\Exceptions\FileUpdateFailedException;
use App\Containers\Files\Models\File;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;

/**
 * Class UpdateFileTask.
 *
 */
class UpdateFileTask extends Task
{
    
    
    /**
     * @param array $data
     * @param       $uuid
     *
     * @return mixed
     */
    public function run(array $data, $uuid)
    {
       
        try {
            DB::beginTransaction();

            $file = File::where('uuid', $uuid)->first();
            unset($data['uuid'], $data['items'], $data['shared'],
                    $data['type'], $data['id'], $data['_method']);
            
            // Check permission
            Gate::authorize('can-edit', [$file, null]);

            $file->update($data);

            DB::commit();
        } catch (\Exception $e) {
            throw (new FileUpdateFailedException())->debug($e);
        }
        return $file->refresh();
    }
    
}
