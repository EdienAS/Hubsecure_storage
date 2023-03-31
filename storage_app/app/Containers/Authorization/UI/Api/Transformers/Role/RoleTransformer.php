<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Role;

use App\Containers\Authorization\Models\Role;
use App\Abstracts\Transformer;

/**
 * Class PermissionTransformer.
 *
 */
class RoleTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Role $role
     *
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'uuid'                 => $role->uuid,
            'title'                => $role->title,
        ];
    }
    
}
