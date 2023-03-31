<?php

namespace App\Containers\User\Tasks;

use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\User\Models\User;
use App\Containers\User\Exceptions\UserException;

/**
 * Class DeleteUserTask.
 *
 */
class DeleteUserTask extends Task
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

            // delete the record from the users table.
            $user = User::where('uuid',$uuid)->first();


            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            throw (new UserException())->debug($e);
        }
        return true;
    }
}
