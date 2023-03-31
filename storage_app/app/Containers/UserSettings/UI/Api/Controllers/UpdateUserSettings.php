<?php

namespace App\Containers\UserSettings\UI\Api\Controllers;

use App\Containers\UserSettings\UI\Api\Requests\UpdateUserSettingsRequest;

use App\Containers\UserSettings\Actions\UpdateUserSettingsAction;

use App\Containers\UserSettings\UI\Api\Transformers\UserSettingsFullTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class UpdateUserSettings.
 *
 */
class UpdateUserSettings extends ControllerApi
{

    /**
     * @param \App\Containers\UserSettings\UI\Api\Requests\UpdateUserSettingsRequest $request
     * @param \App\Containers\UserSettings\Actions\UpdateUserSettingsAction        $action
     *
     * @return  Response
     */
    public function update(UpdateUserSettingsRequest $request, UpdateUserSettingsAction $action)
    {
        
        $action->run($request);
        
        return $this->responseNoContent([
            'message' => 'Usersetting (' . $request->uuid . ') updated Successfully.',
        ]);
    }

}
