<?php

namespace App\Containers\Authentication\Actions;

use App\Abstracts\Action;
use App\Containers\Authentication\Tasks\ApiLoginWithCredentialsTask;

/**
 * Class ApiLoginAction
 * @package App\Containers\Authentication\Actions
 */
class ApiLoginAction extends Action
{
    /**
     * @var \App\Containers\Authentication\Tasks\ApiLoginWithCredentialsTask
     */
    private $apiLoginWithCredentialsTask;
    
    
    /**
     * ApiLoginAction constructor.
     *
     * @param \App\Containers\Authentication\Tasks\ApiLoginWithCredentialsTask $apiLoginWithCredentialsTask
     */
    public function __construct(ApiLoginWithCredentialsTask $apiLoginWithCredentialsTask) {
        $this->apiLoginWithCredentialsTask = $apiLoginWithCredentialsTask;
    }
    
    
    /**
     * @param $email
     * @param $password
     *
     * @return mixed
     */
    public function run($email, $password)
    {
        return $this->apiLoginWithCredentialsTask->run($email, $password);
    }
}
