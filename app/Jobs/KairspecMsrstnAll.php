<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use DB;
use Func;
use Form;
use Log;
use App\Http\Controllers\ApiController;
use App\KairspecApiMsrstnAll;

// 측정소 전체목록 내역 조회
//  - 배치주기 : Daily
class KairspecMsrstnAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Api 조회
        $_SIDO = Array(
            "서울", "부산", "대구", "인천", "광주", "대전", "울산", "경기",
            "강원", "충북", "충남", "전북", "전남", "경북", "경남", "제주", "세종"
        );

        foreach( $_SIDO as $k=>$cityName ){
            usleep(3000);
            // 시도내역을 한번에 땡길 경우, 충북까지만 응답받고 트래픽 이슈로 중단되어 경기까지 응답 후 1분 지연
            if($k==8){
                sleep(60);
            }

            $today = date('Y-m-d');
            $time = date('H:i:s');
            
            //  API - 전체 측정소 목록 (KairspecMsrstnAll) - 시작
            $_DATA['uri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc";
            $_DATA['setUri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc/getMsrstnList";
            $_DATA['data'] = Array(
                "serviceKey"=>env('API_KEY_KAIRSPEC'),
                "numOfRows"=>"9999",
                "pageNo"=>"1",
                "addr"=>$cityName,
                "stationName"=>" "
            );
            $_DATA['setDatabase'] = "getMsrstnList";
            $url = Form::getReqUrl($_DATA);

            Log::info('SCH KairspecMsrstnAll ['.$cityName.'] '.date('Ymd H:i:s'));
            Log::info('SCH KairspecMsrstnAll ['.$cityName.'] Req>'.$url);
            $api = app(ApiController::class);
            $result = $api->curl($url);
            Log::info('SCH KairspecMsrstnAll ['.$cityName.'] Res>'.$result);
            $_ARR = json_decode($result, 1);

            foreach( $_ARR['body']['items'] as $item=>$datas ){
                foreach($datas as $cols){
                    
                    // today, city, stationName
                    $obj = KairspecApiMsrstnAll::select('_id')
                    ->where('city', '=', trim($cityName))
                    ->where('today', '=', $today)
                    ->where('stationName', '=', trim($cols['stationName']))
                    ->orderBy('today', 'desc')
                    ->take(1)
                    ->get();

                    // Collection ObjectId
                    if(empty($obj[0]['_id'])){
                        $oid=null;
                    }else{
                        $oid = $obj[0]['_id'];
                    }
                                        
                    unset($api);
                    if($oid){
                        Log::info($oid." > ".$cityName."/".$today."/".$cols['stationName']);
                        $api = KairspecApiMsrstnAll::find($oid);
                        $api->today = $today;
                        $api->time = $time;
                        $api->city = $cityName;
                        $api->stationName = $cols['stationName'];
                        $api->addr = $cols['addr'];
                        $api->dmX = $cols['dmX'];
                        $api->dmY = $cols['dmY'];
                        $api->save();
                        
                    }else{
                        Log::info("New > ".$cityName."/".$today."/".$cols['stationName']);
                        $api = new KairspecApiMsrstnAll();
                        $api->today = $today;
                        $api->time = $time;
                        $api->city = $cityName;
                        $api->stationName = $cols['stationName'];
                        $api->addr = $cols['addr'];
                        $api->dmX = $cols['dmX'];
                        $api->dmY = $cols['dmY'];
                        $api->save();
                    }
                }
            }
            Log::info('SCH KairspecMsrstnAll ['.$cityName.'] Res>OK');
            //  API - 전체 측정소 목록 (KairspecMsrstnAll) - 종료


            if($k==8){
                sleep(60);
            }
            //  API - 전체 측정소 목록 (KairspecCtprvnRltmMesureDnsty) - 시작
            $_DATA['uri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc";
            $_DATA['setUri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getCtprvnRltmMesureDnsty";
            $_DATA['data'] = Array(
                "serviceKey"=>env('API_KEY_KAIRSPEC'),
                "numOfRows"=>"9999",
                "pageNo"=>"1",
                "sidoName"=>$cityName,
                "ver"=>"1.3"
            );
            $_DATA['setDatabase'] = "getCtprvnRltmMesureDnsty";
            $url = Form::getReqUrl($_DATA);

            Log::info('SCH KairspecCtprvnRltmMesureDnsty ['.$cityName.'] '.date('Ymd H:i:s'));
            Log::info('SCH KairspecCtprvnRltmMesureDnsty ['.$cityName.'] Req>'.$url);
            $api = app(ApiController::class);
            $result = $api->curl($url);
            Log::info('SCH KairspecCtprvnRltmMesureDnsty ['.$cityName.'] Res>'.$result);
            $_ARR = json_decode($result, 1);

            foreach( $_ARR['body']['items'] as $item=>$datas ){
                foreach($datas as $cols){
                    
                    // today, city, stationName
                    $obj = KairspecApiMsrstnAll::select('_id')
                    ->where('city', '=', trim($cityName))
                    ->where('today', '=', $today)
                    ->where('stationName', '=', trim($cols['stationName']))
                    ->orderBy('today', 'desc')
                    ->take(1)
                    ->get();

                    // Collection ObjectId
                    if(empty($obj[0]['_id'])){
                        $oid=null;
                    }else{
                        $oid = $obj[0]['_id'];
                    }
              
                    unset($api);
                    if($oid){
                        Log::info($oid." > ".$cityName."/".$today."/".$cols['stationName']);
                        $api = KairspecApiMsrstnAll::find($oid);
                        $api->time = $time;
                        $api->mesure_time=$cols['dataTime'];
                        $api->so2Value=$cols['so2Value'];
                        $api->coValue=$cols['coValue'];
                        $api->o3Value=$cols['o3Value'];
                        $api->no2Value=$cols['no2Value'];
                        $api->pm10Value=$cols['pm10Value'];
                        $api->pm10Value24=$cols['pm10Value24'];
                        $api->pm25Value=$cols['pm25Value'];
                        $api->pm25Value24=$cols['pm25Value24'];
                        $api->khaiValue=$cols['khaiValue'];
                        $api->khaiGrade=$cols['khaiGrade'];
                        $api->so2Grade=$cols['so2Grade'];
                        $api->coGrade=$cols['coGrade'];
                        $api->o3Grade=$cols['o3Grade'];
                        $api->no2Grade=$cols['no2Grade'];
                        $api->pm10Grade=$cols['pm10Grade'];
                        $api->pm25Grade=$cols['pm25Grade'];
                        $api->pm10Grade1h=$cols['pm10Grade1h'];
                        $api->pm25Grade1h=$cols['pm25Grade1h'];
                        $api->save();
                        
                    }else{
                        Log::info("ERR>Invalid Station Name > ".$cityName."/".$today."/".$cols['stationName']);
                    }
                }
            }
            Log::info('SCH KairspecMsrstnAll ['.$cityName.'] Res>OK');



            //  API - 전체 측정소 목록 (KairspecCtprvnRltmMesureDnsty) - 종료
        }        
    }
}
