<?php

namespace App\Containers\Notifications\Tasks;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Notifications\Exceptions\ReadNotificationException;

/**
 * Class ReadNotificationTask.
 *
 */
class ReadNotificationTask extends Task
{

    /**
     * @return boolean
     */
    public function run()
    {
        try{
            
            DB::beginTransaction();

            // Mark all notifications as read
            auth()
                ->user()
                ->unreadNotifications()
                ->update([
                    'read_at' => now(),
                ]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            throw (new ReadNotificationException())->debug($e);
        }
    }
    
}
