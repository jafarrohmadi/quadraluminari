<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = me();

        if (!app()->runningInConsole() && $user) {
            $roles            = Permission::get();
            $permissionsArray = $user->permission->pluck('id')->toArray();

            foreach ($roles as $permission) {
                Gate::define($permission->title, function ($user) use ($permissionsArray , $permission) {
                    return in_array($permission->id, $permissionsArray);
                });
            }
        }

        return $next($request);
    }
}
