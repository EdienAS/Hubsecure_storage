<?php

namespace App\Containers\Authorization\Tasks\Permission;

use Exception;
use App\Abstracts\Task;
use Illuminate\Support\Facades\DB;
use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Tasks\SyncTasks\SyncPermissionRoleTask;
use App\Containers\Authorization\Exceptions\Permission\PermissionFailedException;

/**
 * Class CreatePermissionTask.
 *
 */
class CreatePermissionTask extends Task
{

    /**
     * @var  SyncPermissionRoleTask
     */
    private $syncPermissionRoleTask;
    
    
    /**
     * SyncPermissionRoleTask constructor.
     *
     * @param \App\Containers\User\Tasks\SyncPermissionRoleTask     $syncPermissionRoleTask
     */
    public function __construct(
        SyncPermissionRoleTask $syncPermissionRoleTask
    ) {
        $this->syncPermissionRoleTask = $syncPermissionRoleTask;
    }

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

                $permission = Permission::create($data);
                $this->syncPermissionRoleTask->run();

            DB::commit();

        } catch (Exception $e) {
            throw (new PermissionFailedException())->debug($e);
        }

        return $permission;
    }


}
