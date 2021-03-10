<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KairspecApiMsrstnAll;

class MapController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $list = KairspecApiMsrstnAll::where('today', '=', $today)
        ->get();
        
        $_MARKER = Array();
        foreach($list as $datas){
            $_MARKER[$datas['stationName']]['city'] = $datas['city']; 
            $_MARKER[$datas['stationName']]['dmX'] = $datas['dmX'];
            $_MARKER[$datas['stationName']]['dmY'] = $datas['dmY'];
            $_MARKER[$datas['stationName']]['mesure_time'] = $datas['mesure_time'];
            $_MARKER[$datas['stationName']]['mesure_pm10'] = $datas['pm10Value'];  //  미세먼지 농도
            $_MARKER[$datas['stationName']]['mesure_pm25'] = $datas['pm25Value'];  //  초미세먼지 농도
            $_MARKER[$datas['stationName']]['mesure_pm10h1'] = $datas['pm10Grade1h'];  //  미세먼지 1시간 등급자료
            $_MARKER[$datas['stationName']]['mesure_pm25h1'] = $datas['pm25Grade1h'];  //  초미세먼지 1시간 등급자료
        }

        return view('map/index')->with('marker', $_MARKER);
    }
}
