<?php

namespace App\Containers\User\UI\Api\Controllers\Blacklist;

use Response;
use App\Abstracts\ControllerApi;

use App\Containers\User\Actions\Blacklist\DestroyBlacklistAction;

use App\Containers\User\UI\Api\Requests\Blacklist\DestroyBlacklistRequest;

/**
 * Class DestroyBlacklist.
 *
 */
class DestroyBlacklist extends ControllerApi
{

    /**
     * @param \App\Containers\User\UI\Api\Requests\Blacklist\DestroyBlacklistRequest $request
     * @param \App\Containers\User\Actions\Blacklist\DestroyBlacklistAction          $action
     *
     * @return  Response
     */
    public function destroy(DestroyBlacklistRequest $request, DestroyBlacklistAction $action)
    {
        $action->run($request);

        return $this->responseNoContent([
            'message' => 'User (' . $request->uuid . ') Blacklist Deleted Successfully.',
        ]);
    }

    
}
