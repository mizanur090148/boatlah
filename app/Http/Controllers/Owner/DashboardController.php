<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use Sentinel;

use App\BoatOwnerProfile;

class DashboardController extends Controller {

    protected $ownerUserID, $ownerProfileID;

    /**
     * Create a new CoordinatorController controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ownerUserID = Sentinel::getUser()->getUserId();
        $this->ownerProfileID =  BoatOwnerProfile::where('user_id', $this->ownerUserID)->first()->id;
    }
}
