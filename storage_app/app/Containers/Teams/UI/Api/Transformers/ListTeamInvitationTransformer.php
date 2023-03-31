<?php

namespace App\Containers\Teams\UI\Api\Transformers;

use App\Abstracts\Transformer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListTeamInvitationTransformer.
 *
 */
class ListTeamInvitationTransformer extends Transformer
{

    /**
     * @return array
     */
    public function transform($invitation)
    {
        return $this->handleData($invitation);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Collection $invitation)
    {
        
        
        
        return $invitation->toArray();
    }
}
