<?php

namespace App\Containers\User\UI\Api\Transformers;

use App\Abstracts\Transformer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListUserTransformer.
 *
 */
class ListUserTransformer extends Transformer
{

    /**
     * @return array
     */
    public function transform($users)
    {
        return $this->handleData($users);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Collection $users)
    {
        $data = $users->toArray();
        $finalData = array();
        foreach($data as $user){
            
            unset($user['id']);
            unset($user['created_at']);
            unset($user['updated_at']);
            unset($user['deleted_at']);
            unset($user['role_id']);
            
            unset($user['role']['id']);
            unset($user['role']['created_at']);
            unset($user['role']['updated_at']);
            unset($user['role']['deleted_at']);
            
            $finalData[] = $user;
        }
        
        return $finalData;
    }
}
