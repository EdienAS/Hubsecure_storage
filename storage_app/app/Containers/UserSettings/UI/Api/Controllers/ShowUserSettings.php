<?php

namespace App\Containers\UserSettings\UI\Api\Controllers;

use App\Containers\UserSettings\UI\Api\Requests\ShowUserSettingsRequest;

use App\Containers\UserSettings\Actions\ShowUserSettingsAction;


use App\Containers\UserSettings\UI\Api\Transformers\UserSettingsTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class ShowUserSettings.
 *
 */
class ShowUserSettings extends ControllerApi
{

    /**
     * @param \App\Containers\UserSettings\UI\Api\Requests\ShowUserSettingsRequest $request
     * @param \App\Containers\UserSettings\Actions\ShowUserSettingsAction      $action
     *
     * @return Response
     */
    public function show(ShowUserSettingsRequest $request, ShowUserSettingsAction $action)
    {
        return $this->responseItem($action->run($request), new UserSettingsTransformer());
    }
    
}
