<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Role;

use App\Abstracts\Transformer;
use App\Containers\Authorization\Models\Role;

/**
 * Class ShowRoleTransformer.
 *
 */
class ShowRoleTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Role $role
     *
     * @return array
     */
    public function transform($role)
    {
        return $this->handleData($role);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Role $role)
    {
        $role = $role->toArray();
        
        $finalData = $finalRole = array();
            
            unset($role['id']);
            unset($role['created_at']);
            unset($role['updated_at']);
            unset($role['deleted_at']);
            
            foreach($role['permissions'] as $j => $permission){
                
                unset($permission['id']);
                unset($permission['created_at']);
                unset($permission['updated_at']);
                unset($permission['deleted_at']);
                unset($permission['pivot']);
                
                $role['permissions'][$j] = $permission;
            }
            
            $finalData[] = $role;
        
        return $finalData;
    }
}
