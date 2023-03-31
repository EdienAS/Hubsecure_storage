<?php

namespace App\Containers\User\Policies;

use App\Abstracts\Policy;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Containers\User\Models\User;

/**
 * Class UserPolicy.
 *
 */
class UserPolicy extends Policy
{
    use HandlesAuthorization;
    
    
    /**
     * @param \App\Containers\User\Models\User $user
     * @param \App\Containers\User\Models\User $item
     *
     * @return bool
     */
    public function view(User $user, User $item)
    {
//        return $user->hasRole(['admin']) ? true : ($user->id==$item->id);
        return true; //@todo: research usages
    }
    
    
    /**
     * @param \App\Containers\User\Models\User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }
    
    
    /**
     * @param \App\Containers\User\Models\User $user
     * @param \App\Containers\User\Models\User $item
     *
     * @return bool
     */
    public function update(User $user, User $item)
    {
        return true;
    }
    
    
    /**
     * @param \App\Containers\User\Models\User $user
     * @param \App\Containers\User\Models\User $item
     *
     * @return bool
     */
    public function delete(User $user, User $item)
    {
        return true;
    }
}
