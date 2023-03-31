<?php

namespace App\Containers\Files\Tasks;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Files\Exceptions\FileRestoreException;

/**
 * Class RestoreTask.
 *
 */
class RestoreTask extends Task
{

    /**
     * @param $id
     *
     * @return bool
     */
    public function run($request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->input('items') as $item) {
                $entry = get_item_by_uuid($item['type'], $item['uuid']);
                
                // Restore item to home directory
                if ($request->has('to_home') && $request->input('to_home')) {
                    $entry->update(['parent_folder_id' => null]);
                }

                // Restore Item
                $entry->restore();

            }
            DB::commit();
        } catch (\Exception $e) {
            throw (new FileRestoreException())->debug($e);
        }

        return true;
    }
}
