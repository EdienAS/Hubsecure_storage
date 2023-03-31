<?php

namespace App\Containers\Authentication\Tasks;

use App\Containers\Authentication\Exceptions\AuthenticationFailedException;
use App\Abstracts\Task;
use Exception;

/**
 * Class ApiLoginThisUserObjectTask.
 *
 */
class ApiLoginThisUserObjectTask extends Task
{
    
    
    /**
     * @param $user
     *
     * @return \App\Containers\User\Models\User
     */
    public function run($user)
    {
        try {
            $user['token'] = $user->createToken(env('APP_NAME'))->accessToken;
        } catch (Exception $e) {
            throw (new AuthenticationFailedException())->debug($e);
        }
        
        

        return $user;
    }

}
