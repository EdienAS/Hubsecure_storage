<?php

namespace App\Containers\Authorization\Tasks\Role;

use App\Containers\Authorization\Exceptions\Role\RoleFailedException;
use App\Abstracts\Task;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Containers\Authorization\Models\Role;

/**
 * Class CreateRoleTask.
 *
 */
class CreateRoleTask extends Task
{


    /**
     * @param array $data
     * @param bool  $login
     *
     * @return mixed
     */
    public function run(array $data)
    {
        try {
            
            DB::beginTransaction();

                $role = Role::create($data);

            DB::commit();

        } catch (Exception $e) {
            throw (new RoleFailedException())->debug($e);
        }

        return $role;
    }


}
