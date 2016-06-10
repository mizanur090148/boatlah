<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelRedirectUser
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
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            $adminRole = Sentinel::findRoleBySlug('admin');
            $userRole = Sentinel::findRoleBySlug('user');
            $ownerRole = Sentinel::findRoleBySlug('owner');
            $companyRole = Sentinel::findRoleBySlug('company');
            $coordinatorRole = Sentinel::findRoleBySlug('coordinator');

            if ($user->inRole($adminRole)) {
                return redirect('admin/dashboard');
            } elseif ($user->inRole($userRole)) {
                return redirect('user/dashboard');
            } elseif ($user->inRole($ownerRole)) {
                return redirect('owner/dashboard');
            } elseif ($user->inRole($companyRole)) {
                return redirect('company/dashboard');
            } elseif ($user->inRole($coordinatorRole)) {
                return redirect('coordinator/dashboard');
            }  
        }
        return $next($request);
    }
}
