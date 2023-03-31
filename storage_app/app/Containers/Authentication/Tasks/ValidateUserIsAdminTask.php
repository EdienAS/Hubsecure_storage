<?php

namespace App\Containers\Authentication\Tasks;

use App\Containers\Authentication\Exceptions\UserNotAdminException;
use App\Containers\User\Models\User;
use App\Abstracts\Task;

/**
 * Class ValidateUserIsAdminTask.
 *
 */
class ValidateUserIsAdminTask extends Task
{

    /**
     * @param \App\Containers\User\Models\User $user
     *
     * @return  bool
     */
    public function run(User $user)
    {
        // check if is Admin
        $isAdmin = $user->hasRole('admin');

        if (!$isAdmin) {
            throw new UserNotAdminException();
        }

        return true;
    }

}
