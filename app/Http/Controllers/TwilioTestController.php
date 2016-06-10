<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Twilio;


class TwilioTestController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Twilio::message('+8801720205877', 'Pink Elephants and Happy Rainbows');
    }

}
