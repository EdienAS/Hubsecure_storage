<?php

namespace App\Containers\Share\Tasks;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Share\Models\Share;
use App\Containers\Folders\Models\Folder;
use App\Containers\Share\Resources\ShareResource;
use App\Containers\Share\Exceptions\ShareItemUpdateException;

/**
 * Class UpdateShareItemTask.
 *
 */
class UpdateShareItemTask extends Task
{
    
    
    /**
     * @param array $data
     * @param       $id
     *
     * @return mixed
     */
    public function run(array $data, $token)
    {
       
        try {
            DB::beginTransaction();

            $shareItem = Share::where('token', $token)->first();
            unset($data['token']);
            
            $item = get_item_by_id($shareItem->type, $shareItem->item_id);
            
            // If sharing folder, check permission attribute
            if ($item instanceof Folder && empty($data['permission'])) {
//                return response()->json([
//                    'type'    => 'error',
//                    'message' => 'The permission field for folder is required.',
//                ], 422);
                abort(422, 'The permission field for folder is required.');
            }

            
            $shareItem->update($data);

            DB::commit();
        } catch (\Exception $e) {
            throw (new ShareItemUpdateException())->debug($e);
        }
        return new ShareResource($shareItem->refresh());
    }
    
}
