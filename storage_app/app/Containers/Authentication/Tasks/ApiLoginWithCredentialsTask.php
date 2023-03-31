<?php

namespace App\Containers\Authentication\Tasks;

use Auth;
use Exception;
use App\Abstracts\Task;
use App\Containers\User\Models\Blacklist;
use App\Containers\Authentication\Exceptions\BlacklistUserException;
use App\Containers\Authentication\Exceptions\AuthenticationFailedException;

/**
 * Class ApiLoginWithCredentialsTask
 * @package App\Containers\Authentication\Tasks
 */
class ApiLoginWithCredentialsTask extends Task
{
    
    /**
     * @var \App\Containers\Authentication\Tasks\GetAuthenticatedUserTask
     */
    private $getAuthenticatedUserTask;
        
    
    /**
     * ApiLoginWithCredentialsTask constructor.
     *
     * @param \App\Containers\Authentication\Adapters\JwtAuthAdapter        $jwtAuthAdapter
     * @param \App\Containers\Authentication\Tasks\GetAuthenticatedUserTask $getAuthenticatedUserTask
     * @param \App\Containers\Authentication\Tasks\ConnectionRegisterTask   $connectionRegisterTask
     */
    public function __construct(
        GetAuthenticatedUserTask $getAuthenticatedUserTask
    ) {
        $this->getAuthenticatedUserTask = $getAuthenticatedUserTask;
    }
    
    
    /**
     * @param $email
     * @param $password
     *
     * @return \App\Containers\User\Models\User
     */
    public function run($email, $password)
    {
        try {
            if(Auth::attempt([
                    'email' => $email, 
                    'password' => $password, 
                    'is_active' => 1
                ])){ 
                $user = Auth::user(); 
                
                $blacklistUser = Blacklist::where('user_id', $user->id)->first();
                if(!empty($blacklistUser->id)){
                    throw new BlacklistUserException(); 
                }
            } 
            else{ 
                throw new AuthenticationFailedException(); 
            } 

        } catch (Exception $e) {
            throw (new AuthenticationFailedException())->debug($e);
        }

        $user['token'] = $this->getAuthenticatedUserTask->run($user);

        return $user;
    }

}
