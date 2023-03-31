<?php

namespace App\Containers\User\UI\Api\Controllers\Blacklist;

use App\Containers\User\UI\Api\Requests\Blacklist\CreateBlacklistRequest;

use App\Containers\User\Actions\Blacklist\CreateBlacklistAction;

use App\Containers\User\UI\Api\Transformers\UserFullTransformer;

use App\Abstracts\ControllerApi;
use Response;
/**
 * Class CreateBlacklist.
 *
 */
class CreateBlacklist extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\Blacklist\CreateBlacklistRequest $request
     * @param \App\Containers\User\Actions\Blacklist\CreateBlacklistAction        $action
     *
     * @return  Response
     */
    public function create(CreateBlacklistRequest $request, CreateBlacklistAction $action)
    {
        $user = $action->run($request);
                
        return $this->responseCreated($user,[
            'message' => 'User (' . $request->uuid . ') Blacklisted Successfully.',
        ]);
    }

}
