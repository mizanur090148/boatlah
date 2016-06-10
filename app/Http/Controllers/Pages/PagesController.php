<?php

namespace App\Http\Controllers\Pages;

use App\Pages;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Sentinel;


class PagesController extends Controller
{

    public function pages($code)
    {
        $page = Pages::where('url','=',$code)->first();
        return view('pages.page')->with('page',$page);
    }
}
