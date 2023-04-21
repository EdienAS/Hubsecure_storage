<?php

namespace App\Containers\UserSettings\Actions;

use App\Abstracts\RequestHttp;
use App\Containers\UserSettings\Tasks\UpdateUserSettingsTask;
use App\Abstracts\Action;

/**
 * Class UpdateUserSettingsAction.
 *
 */
class UpdateUserSettingsAction extends Action
{

    /**
     * @var  UpdateUserSettingsTask
     */
    private $updateUserSettingsTask;
    
    
    /**
     * UpdateUserSettingsAction constructor.
     *
     * @param \App\Containers\UserSettings\Tasks\UpdateUserSettingsTask     $updateUserSettingsTask
     */
    public function __construct(
        UpdateUserSettingsTask $updateUserSettingsTask
    ) {
        $this->updateUserSettingsTask = $updateUserSettingsTask;
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
        
        $userSettings = $this->updateUserSettingsTask->run($data);
        
        return $userSettings;
    }
}
