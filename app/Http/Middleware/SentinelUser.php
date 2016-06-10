<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelUser
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
        $userUser = Sentinel::findRoleBySlug('user');
        if (!$user->inRole($userUser)) {
            return redirect()->back();
        }
        return $next($request);
    }
}
