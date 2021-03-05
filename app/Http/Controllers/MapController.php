<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(Request $request, $api)
    {
        return view('api/map')->with('api', $api);
    }
}
