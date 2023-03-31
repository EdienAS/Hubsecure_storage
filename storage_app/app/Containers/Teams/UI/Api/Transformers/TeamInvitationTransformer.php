<?php

namespace App\Containers\Teams\UI\Api\Transformers;

use App\Abstracts\Transformer;
use App\Containers\Teams\Models\TeamFolderInvitation;

/**
 * Class TeamInvitationTransformer.
 *
 */
class TeamInvitationTransformer extends Transformer
{

    /**
     * @param \App\Containers\Teams\Models\TeamFolderInvitation $invitation
     *
     * @return array
     */
    public function transform(TeamFolderInvitation $invitation)
    {
        return $this->handleData($invitation);
    }
    
    /**
     * @return array
     */
    private function handleData($invitation)
    { 
        
        unset($invitation->updated_at);
        unset($invitation->deleted_at);

        $invitation = $invitation->toArray();
             
        
        return $invitation;
    }
}
