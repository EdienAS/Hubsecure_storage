<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Role;

use App\Abstracts\Transformer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListRoleTransformer.
 *
 */
class ListRoleTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Role $roles
     *
     * @return array
     */
    public function transform($roles)
    {
        return $this->handleData($roles);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Collection $roles)
    {
        $data = $roles->toArray();
        $finalData = $finalRole = array();
        foreach($data as $k => $role){
            
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
        }
        
        return $finalData;
    }
}
