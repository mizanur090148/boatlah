<?php

namespace App\Http\Controllers\Coordinator;

use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use App\BoatCoardinatorProfile;

class ProfileController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'Profile';

        $data['user_info'] = BoatCoardinatorProfile::findOrFail($this->coordinatorProfileID);

        return view('coordinator.dashboard.profile.index', $data);
    }
}
