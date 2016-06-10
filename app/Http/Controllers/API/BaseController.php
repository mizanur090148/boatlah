<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\BaseAnchorage;

class BaseController extends Controller
{
    /**
     * Display anchorages list
     */
    public function anchorages($zone = NULL)
    {

        if ($zone == NULL){
            $anchorages = BaseAnchorage::all();
        } else {
            $anchorages = BaseAnchorage::where('type', $zone)->get();
        }

        return response()->json([
            'data' => $anchorages->toArray(), 
        ], 200);
    }

}
