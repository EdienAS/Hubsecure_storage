<?php

namespace App\Containers\Authorization\Tasks\Role;

use App\Containers\Authorization\Exceptions\Role\RoleFailedException;
use App\Abstracts\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Containers\Authorization\Models\Role;

/**
 * Class UpdateRoleTask.
 *
 */
class UpdateRoleTask extends Task
{

    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run($data)
    {
        try {
            
            DB::beginTransaction();
            
                $permission = Role::where('uuid', $data['uuid'])->first();
                unset($data['uuid']);

                $permission->update($data);

            DB::commit();

        } catch (Exception $e) {
            throw (new RoleFailedException())->debug($e);
        }

        return $permission;
    }


}
