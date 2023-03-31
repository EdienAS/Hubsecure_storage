<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Tasks\ApiLogoutTask;
use App\Abstracts\Action;

/**
 * Class ApiLogoutAction
 *
 */
class ApiLogoutAction extends Action
{

    /**
     * @var  \App\Containers\Authentication\Tasks\ApiLogoutTask
     */
    private $apiLogoutTask;

    /**
     * ApiLogoutAction constructor.
     *
     * @param \App\Containers\Authentication\Tasks\ApiLogoutTask $apiLogoutTask
     */
    public function __construct(ApiLogoutTask $apiLogoutTask)
    {
        $this->apiLogoutTask = $apiLogoutTask;
    }

    /**
     * @param $request
     *
     * @return bool
     */
    public function run($request)
    {
        return $this->apiLogoutTask->run($request->user());
    }
}
