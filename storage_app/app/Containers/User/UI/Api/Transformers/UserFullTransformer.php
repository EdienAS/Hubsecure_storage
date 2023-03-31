<?php

namespace App\Containers\User\UI\Api\Transformers;

use App\Abstracts\Transformer;
use App\Containers\User\Models\User;

/**
 * Class UserTransformer.
 *
 * @author <>
 */
class UserFullTransformer extends Transformer
{

    /**
     * @param \App\Containers\User\Models\User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'uuid'                 => $user->uuid,
            'name'                 => $user->name,
            'email'                => $user->email,
            'role'                 => $user->role->title,
            'created_at'           => $user->created_at,
            'updated_at'           => $user->updated_at,
            'token'                => $user->token,
        ];
    }
    
}
