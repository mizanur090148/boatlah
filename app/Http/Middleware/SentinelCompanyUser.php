<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelCompanyUser
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
        $company = Sentinel::findRoleBySlug('company');

        if (!$user->inRole($company)) {
            return redirect('login');
        }
        return $next($request);
    }
}
