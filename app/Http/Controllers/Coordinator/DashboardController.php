<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use Sentinel;

use App\BoatCoardinatorProfile;

class DashboardController extends Controller {

    protected $coordinatorUserID, $coordinatorProfileID;

    /**
     * Create a new CoordinatorController controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->coordinatorUserID = Sentinel::getUser()->getUserId();
        $this->coordinatorProfileID =  BoatCoardinatorProfile::where('user_id', $this->coordinatorUserID)->first()->id;
    }
}
