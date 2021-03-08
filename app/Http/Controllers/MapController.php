<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KairspecApiMsrstnAll;

class MapController extends Controller
{
    public function index(Request $request, $api)
    {
        $today = date('Y-m-d');
        $list = KairspecApiMsrstnAll::where('today', '=', $today)
        ->get();
        
        $_MARKER = Array();
        foreach($list as $datas){
            $_MARKER[$datas['stationName']]['city'] = $datas['city']; 
            $_MARKER[$datas['stationName']]['dmX'] = $datas['dmX'];
            $_MARKER[$datas['stationName']]['dmY'] = $datas['dmY'];
        }

        return view('api/map')->with('api', $api)->with('marker', $_MARKER);
    }
}
