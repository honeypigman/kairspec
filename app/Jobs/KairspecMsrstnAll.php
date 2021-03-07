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
use Api;
use Log;
use App\Http\Controllers\ApiController;

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
        $_SIDO = Array(
            "서울", "부산", "대구", "인천", "광주", "대전", "울산", "경기", 
            "강원", "충북", "충남", "전북", "전남", "경북", "경남", "제주", "세종"
        );

        foreach( $_SIDO as $k=>$name ){
            usleep(3000);

            // 시도내역을 한번에 땡길 경우, 충북까지만 응답받고 트래픽 이슈로 중단되어 경기까지 응답 후 1분 지연
            if($k==8){
                sleep(60);
            }
            $_DATA['uri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc";
            $_DATA['setUri'] = "http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc/getMsrstnList";
            $_DATA['data'] = Array(
                "serviceKey"=>env('API_KEY_KAIRSPEC'),
                "numOfRows"=>"9999",
                "pageNo"=>"1",
                "addr"=>$name,
                "stationName"=>" "
            );
            $_DATA['setDatabase'] = "getMsrstnList";
            $url = Form::getReqUrl($_DATA);

            Log::info('SCH KairspecMsrstnAll ['.$name.'] '.date('Ymd H:i:s'));
            Log::info('Req>'.$url);
            $api = app(ApiController::class);
            $result = $api->curl($url);
            Log::info('Res>'.$result);
        }     
        
    }
}
