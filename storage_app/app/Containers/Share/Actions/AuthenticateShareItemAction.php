<?php

namespace App\Containers\Share\Actions;

use App\Abstracts\Action;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Containers\Share\Models\Share;

/**
 * Class ShowShareItemAction.
 *
 */
class AuthenticateShareItemAction extends Action
{
    
    
    /**
     * @param $request
     * @param $share
     *
     * @return boolean
     */
    public function run($request, Share $share)
    {
        
        // Delete share_session if exist
        if ($share->is_protected) {
            cookie()->queue('share_session', '', -1);
            
            // Check password
            if (Hash::check($request->input('password'), $share->password)) {
                
                if($share->type === 'file'){
                    $url = url("/share/{$share->token}/file");
                } else {
                    $url = url("/share/{$share->token}/files/{$share->item_id}");
                }
                
                return true;
            } else {
                return false;
            }

        }
    }
}
