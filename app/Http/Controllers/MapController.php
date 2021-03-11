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

        // PM_Matrix
        //  - https://www.me.go.kr/mamo/web/index.do?menuId=16201
        $_PM[10][1]['MIN']=0;
        $_PM[10][1]['MAX']=30;
        $_PM[10][2]['MIN']=31;
        $_PM[10][2]['MAX']=80;
        $_PM[10][3]['MIN']=81;
        $_PM[10][3]['MAX']=150;
        $_PM[10][4]['MIN']=151;
        $_PM[10][4]['MAX']=999;

        $_PM[25][1]['MIN']=0;
        $_PM[25][1]['MAX']=15;
        $_PM[25][2]['MIN']=16;
        $_PM[25][2]['MAX']=35;
        $_PM[25][3]['MIN']=36;
        $_PM[25][3]['MAX']=75;
        $_PM[25][4]['MIN']=76;
        $_PM[25][4]['MAX']=999;
       
        $_MARKER = Array();
        foreach($list as $datas){

            if( $datas['pm10Value']=='-' ){
                $datas['pm10Value']='x';
            }
            if( $datas['pm25Value']=='-' ){
                $datas['pm25Value']='x';
            }
            
            // Set Grade
            unset($getGrade);
            $pm10 = $datas['pm10Value'];
            $pm25 = $datas['pm25Value'];
            $getGrade[10]=0;
            foreach($_PM['10'] as $grade => $matrix){
                $is=false;
                if( $is == false && ($pm10>=$matrix['MIN'] && $matrix['MAX'] >= $pm10) ){
                    $is = true;
                }
                if($is){
                    $getGrade[10] = $grade;
                }
            }
            $getGrade[25]=0;
            foreach($_PM['25'] as $grade => $matrix){
                $is=false;
                if( $is == false && ($pm25>=$matrix['MIN'] && $matrix['MAX'] >= $pm25) ){
                    $is = true;
                }
                if($is){
                    $getGrade[25] = $grade;
                }
            }

            $getGrade = max($getGrade);
            if($datas['pm10Value']=='x' && $datas['pm25Value']=='x'){
                $getGrade=0;
            }
            
            // Grade Message
            $_MSG[0]="정보가 없어요..";
            $_MSG[1]="좋음";
            $_MSG[2]="보통";
            $_MSG[3]="나쁨";
            $_MSG[4]="매우나쁨";

            $_MARKER[$datas['stationName']]['grade'] = $getGrade;
            $_MARKER[$datas['stationName']]['msg'] = $_MSG[$getGrade];
            $_MARKER[$datas['stationName']]['gradePm10'] = $getGrade[10];
            $_MARKER[$datas['stationName']]['gradePm25'] = $getGrade[25];
            $_MARKER[$datas['stationName']]['city'] = $datas['city']; 
            $_MARKER[$datas['stationName']]['dmX'] = $datas['dmX'];
            $_MARKER[$datas['stationName']]['dmY'] = $datas['dmY'];
            $_MARKER[$datas['stationName']]['mesure_date'] = $datas['mesure_time'];
            $_MARKER[$datas['stationName']]['mesure_pm10'] = ($datas['pm10Value']?$datas['pm10Value']:'x');  //  미세먼지 농도
            $_MARKER[$datas['stationName']]['mesure_pm25'] = ($datas['pm25Value']?$datas['pm25Value']:'x');  //  초미세먼지 농도
            $_MARKER[$datas['stationName']]['mesure_pm10h1'] = $datas['pm10Grade1h'];  //  미세먼지 1시간 등급자료
            $_MARKER[$datas['stationName']]['mesure_pm25h1'] = $datas['pm25Grade1h'];  //  초미세먼지 1시간 등급자료
        }

        return view('map/index')->with('marker', $_MARKER);
    }
}
