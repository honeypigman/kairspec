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
        // 시도내역 - 서울, 부산, 대구, 인천, 광주, 대전, 울산, 경기, 강원, 충북, 충남, 전북, 전남, 경북, 경남, 제주, 세종       
        // $_SIDO = Array(
        //     "서울", "부산", "대구", "인천", "광주", "대전", "울산", "경기", 
        //     "강원", "충북", "충남", "전북", "전남", "경북", "경남", "제주", "세종"
        // );
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

            //  API - 측정소 전체 목록 조회
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
            Log::info('Req>'.$url);
            $api = app(ApiController::class);
            $result = $api->curl($url);
            Log::info('Res>'.$result);
            $_ARR = json_decode($result, 1);

            $today = date('Y-m-d');
            $time = date('H:i:s');
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
            Log::info('Res>OK');
        }        
    }
}
