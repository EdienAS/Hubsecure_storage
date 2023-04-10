<?php

namespace App\Containers\UserSettings\Actions;

use App\Abstracts\Action;
use App\Traits\StorageDiskTrait;

/**
 * Class GetUserAvatarAction.
 *
 */
class GetUserAvatarAction extends Action
{
    use StorageDiskTrait;
    
    /**
     * @param $request
     *
     * @return mixed
     */
    public function run($request)
    {
        $temp = (app()->environment() == 'testing') ? 'testing/' : null;
        return $this->getStorageDisk()->download($temp. "/avatar/" . auth()->user()->id . "/$request->name", $request->name);
    }
}
