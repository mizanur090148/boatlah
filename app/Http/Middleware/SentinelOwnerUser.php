<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelOwnerUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Sentinel::getUser();
        $owner = Sentinel::findRoleBySlug('owner');

        if (!$user->inRole($owner)) {
            return redirect('login');
        }
        return $next($request);
    }
}
