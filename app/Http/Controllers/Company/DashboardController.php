<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use Sentinel;

use App\ShippingCompanyProfile;

class DashboardController extends Controller {

    protected $companyUserID, $companyProfileID;

    /**
     * Create a new CoordinatorController controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->companyUserID = Sentinel::getUser()->getUserId();
        $this->companyProfileID =  ShippingCompanyProfile::where('user_id', $this->companyUserID)->first()->id;
    }
}
