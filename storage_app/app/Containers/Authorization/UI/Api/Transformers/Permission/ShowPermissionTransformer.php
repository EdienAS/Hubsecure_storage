<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Permission;

use App\Abstracts\Transformer;
use App\Containers\Authorization\Models\Permission;

/**
 * Class ShowPermissionTransformer.
 *
 */
class ShowPermissionTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Permission $permission
     *
     * @return array
     */
    public function transform($permission)
    {
        return $this->handleData($permission);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Permission $permission)
    {
        
        $finalData = $finalRole = array();
            
            unset($permission['id']);
            unset($permission['created_at']);
            unset($permission['updated_at']);
            unset($permission['deleted_at']);
            
            foreach($permission['roles'] as $j => $role){
                
                unset($role['id']);
                unset($role['created_at']);
                unset($role['updated_at']);
                unset($role['deleted_at']);
                
                $permission['roles'][$j] = $role;
            }
            
            $finalData[] = $permission;
        
        return $finalData;
    }
}
