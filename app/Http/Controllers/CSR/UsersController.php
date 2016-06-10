<?php

namespace App\Http\Controllers\CSR;

use App\BoatUserProfile;
use App\CSR;
use App\Http\Requests;
use Sentinel;

class UsersController extends DashboardController
{

    public function index()
    {
        $data['current_page'] = 'Users';
        $data['boat_users'] = BoatUserProfile::all();
        return view('csr.dashboard.users.all_users', $data);
    }

}
