<?php

namespace App\Http\Controllers\CaptainAPI;

use App\Http\Controllers\Controller;

class CaptainAPIController extends Controller
{
    /**
     * API Response
     */
    public function apiResponse($type, $code, $data)
    {
        if ($type == 'error'){
            return response()->json([ 
                    $type => ['msg' => $data]
                ], $code);
        } else {
            return response()->json([
                    'data' => $data
                ], $code);
        }
    }
}
