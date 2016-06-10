<?php

namespace App\Http\Controllers\CSR;

use App\CSR;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Sentinel;

class DashboardController extends Controller {

    protected $csrUserID, $csrProfileID;
    public function __construct()
    {
        $this->csrUserID = Sentinel::getUser()->getUserId();
        $this->csrProfileID =  CSR::where('user_id', $this->csrUserID)->first()->id;
    }
}
