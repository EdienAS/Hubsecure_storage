<?php

namespace App\Http\Middleware;

use App\Containers\Authorization\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();

        if ((!app()->runningInConsole() && $user) || app()->environment() == 'testing') {
            $roles            = Role::with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function (\App\Containers\User\Models\User $user) use ($roles) {
                    return count(array_intersect(explode(',',$user->role->id), $roles)) > 0;
                });
            }
        }
        
        return $next($request);
    }
}
