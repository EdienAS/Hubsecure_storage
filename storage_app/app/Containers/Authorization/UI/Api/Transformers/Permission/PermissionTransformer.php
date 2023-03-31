<?php

namespace App\Containers\Authorization\UI\Api\Transformers\Permission;

use App\Abstracts\Transformer;
use App\Containers\Authorization\Models\Permission;

/**
 * Class PermissionTransformer.
 *
 */
class PermissionTransformer extends Transformer
{

    /**
     * @param \App\Containers\Authorization\Models\Permission $permission
     *
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'uuid'                   => $permission->uuid,
            'title'                => $permission->title,
        ];
    }
}
