<?php

namespace App\Containers\User\Tasks\Blacklist;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use App\Containers\User\Models\Blacklist;
use App\Containers\User\Exceptions\DestroyBlacklistException;

/**
 * Class DestroyBlacklistTask.
 *
 */
class DestroyBlacklistTask extends Task
{

    /**
     * @param $uuid
     *
     * @return bool
     */
    public function run($uuid)
    {
        try {
            DB::beginTransaction();

            $user = User::where('uuid',$uuid)->first();
            
            // delete the record from the blacklist table.
            Blacklist::where('user_id', $user->id)->delete();


            DB::commit();
        } catch (\Exception $e) {
            throw (new DestroyBlacklistException())->debug($e);
        }
        return true;
    }
}
