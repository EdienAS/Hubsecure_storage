<?php

namespace App\Containers\User\Actions\Blacklist;

use App\Abstracts\RequestHttp;
use App\Containers\User\Tasks\Blacklist\CreateBlacklistTask;
use App\Abstracts\Action;

/**
 * Class CreateBlacklistAction.
 *
 */
class CreateBlacklistAction extends Action
{

    /**
     * @var  CreateBlacklistTask
     */
    private $createBlacklistTask;
    
    
    /**
     * CreateBlacklistAction constructor.
     *
     * @param \App\Containers\User\Tasks\Blacklist\CreateBlacklistTask     $createBlacklistTask
     */
    public function __construct(
        CreateBlacklistTask $createBlacklistTask
    ) {
        $this->createBlacklistTask = $createBlacklistTask;
    }
    
    
    /**
     * @param RequestHttp $request
     * @param bool $login
     *
     * @return mixed
     */
    public function run($request)
    {
        $data = $request->all();

        $user = $this->createBlacklistTask->run($data);
        
        return $user;
    }
}
