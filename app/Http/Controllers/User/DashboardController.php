<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use Sentinel;

use App\BoatUserProfile;

class DashboardController extends Controller {

    protected $boatUserID, $boatUserProfileID;

    /**
     * Create a new CoordinatorController controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->boatUserID = Sentinel::getUser()->getUserId();
        $this->boatUserProfileID =  BoatUserProfile::where('user_id', $this->boatUserID)->first()->id;
    }
}
