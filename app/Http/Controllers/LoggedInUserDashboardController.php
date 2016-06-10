<?php

namespace App\Http\Controllers;

use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

class LoggedInUserDashboardController extends Controller {

    public function index() 
    {
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

}
