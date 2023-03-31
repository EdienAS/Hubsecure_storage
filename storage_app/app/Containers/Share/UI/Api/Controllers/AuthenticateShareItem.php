<?php

namespace App\Containers\Share\UI\Api\Controllers;

use App\Abstracts\ControllerApi;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Actions\AuthenticateShareItemAction;
use App\Containers\Share\UI\Api\Requests\AuthenticateShareRequest;
/**
 * Class AuthenticateShareItem.
 *
 */
class AuthenticateShareItem extends ControllerApi
{

    /**
     * Authenticate Share Item
     */
    
    public function authenticate(AuthenticateShareRequest $request, AuthenticateShareItemAction $action,
            Share $shared)
    {
        $authentication = $action->run($request, $shared);
        
        if($authentication === true){
            return $this->responseNoContent([
            'message' => 'Authenticated.'
            ]);
        } else {
            return $this->responseUnauthorized([
                'message' => 'Unauthenticated.'
            ]);
        }
    }
    
}
