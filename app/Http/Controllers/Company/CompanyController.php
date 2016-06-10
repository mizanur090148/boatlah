<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BoatOwnerProfile;

class CompanyController extends Controller
 {

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = BoatOwnerProfile::where('user_id', $id)->first();
        return view('owner.profile')->with('owner', $owner);
    }

    public function edit()
    {

    }

}
