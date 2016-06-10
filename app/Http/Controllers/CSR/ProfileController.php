<?php

namespace App\Http\Controllers\CSR;

use App\CSR;
use App\Http\Requests;
use Sentinel;

class ProfileController extends DashboardController
 {

    public function index() 
    {
        $data['current_page'] = 'Profile';
        $data['user_info'] = CSR::findOrFail($this->csrProfileID);
        return view('csr.dashboard.profile.index', $data);
    }

}
