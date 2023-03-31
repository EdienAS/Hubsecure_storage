<?php

namespace App\Containers\Notifications\Tasks;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Notifications\Exceptions\DestroyNotificationException;

/**
 * Class DestroyNotificationTask.
 *
 */
class DestroyNotificationTask extends Task
{

    /**
     * @return boolean
     */
    public function run()
    {
        try{
            
            DB::beginTransaction();

            // Delete all notifications
            auth()
                ->user()
                ->notifications()
                ->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            throw (new DestroyNotificationException())->debug($e);
        }
    }
    
}
