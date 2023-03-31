<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use App\Containers\Share\Models\Share;
use App\Containers\Share\Resources\ShareResource;

/**
 * Class ShowShareItemAction.
 *
 */
class ShowShareItemAction extends Action
{
    
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $share = Share::with('user')->where('token',$request->token)->first();
        return array('items' => array(new ShareResource($share)));
    }
}
