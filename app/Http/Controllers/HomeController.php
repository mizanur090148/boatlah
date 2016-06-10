<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\BaseAnchorage;
use App\Boat;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anchorages = BaseAnchorage::where('type','MSP')->get();

        $total_boats = Boat::count();
       
        $data['fullpage'] = TRUE;
        return view('home', $data)->with(['anchorages' => $anchorages, 'total_boats' => $total_boats]);
    }

}
