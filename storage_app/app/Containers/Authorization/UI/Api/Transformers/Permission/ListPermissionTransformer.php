<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Permission;

use App\Abstracts\Transformer;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ListPermissionTransformer.
 *
 */
class ListPermissionTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Permission $permissions
     *
     * @return array
     */
    public function transform($permissions)
    {
        return $this->handleData($permissions);
    }
    
    
    /**
     * @return array
     */
    private function handleData(Collection $permissions)
    {
        $data = $permissions->toArray();
        $finalData = $finalRole = array();
        foreach($data as $k => $permission){
            
            unset($permission['id']);
            unset($permission['created_at']);
            unset($permission['updated_at']);
            unset($permission['deleted_at']);
            
            foreach($permission['roles'] as $j => $role){
                
                unset($role['id']);
                unset($role['created_at']);
                unset($role['updated_at']);
                unset($role['deleted_at']);
                unset($role['pivot']);
                
                $permission['roles'][$j] = $role;
            }
            
            $finalData[] = $permission;
        }
        
        return $finalData;
    }
}
