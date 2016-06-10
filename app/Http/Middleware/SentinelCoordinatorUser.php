<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelCoordinatorUser
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
        $cooridnator = Sentinel::findRoleBySlug('coordinator');

        if (!$user->inRole($cooridnator)) {
            return redirect('login');
        }
        return $next($request);
    }
}
