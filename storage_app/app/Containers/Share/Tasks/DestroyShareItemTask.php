<?php

namespace App\Containers\Share\Tasks;

use App\Containers\Share\Exceptions\ShareItemDestroyException;
use App\Containers\Share\Models\Share;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use Auth;

/**
 * Class DestroyShareItemTask.
 *
 */
class DestroyShareItemTask extends Task
{

    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        
        try {
            
                DB::beginTransaction();
                
                $record = Share::whereIn('token', $request->input('tokens'))
                    ->where('user_id', Auth::id())
                    ->delete();
            
                DB::commit();
        } catch (\Exception $e) {
            throw (new ShareItemDestroyException())->debug($e);
        }

        return true;
    }
}
