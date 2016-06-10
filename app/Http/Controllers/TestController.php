<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Event;
use App\Events\QueueTest;

class TestController extends Controller
{

    public function index()
    {
        Event::fire(new QueueTest());
        return 'hmm';
    }



}
