<?php
/**
 *  Title : Api Controller | Honeypigman@gmail.com
 *  Date : 2021.02.25
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use DB;
use Func;
use Form;
use Api;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        $this->index();
        return view('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type='json')
    {
        $result = Api::orderBy('reqdate', 'desc')->get();        

        if($type=='json'){
            return $result = $result->toJson(JSON_UNESCAPED_UNICODE);
        }else{
            return $result = $result->toArray();
        }
    }

    public function setForm(Request $reqeust, $api_code)
    {
        $_DATA = Form::getData($api_code);        
        $_DATA['req']['serviceKey']['val'] = env('API_KEY');
        return view('api/layout')->with('result', $_DATA);
    }

    public function send(Request $request)
    {
        $_DATA = Func::requestToData($request);
        $query_string = Form::setQueryString($_DATA);
        $url = $_DATA['uri']."/".$_DATA['operation']."?".$query_string;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec ($ch);
        $err = curl_error($ch);  //if you need
        curl_close ($ch);

        // Xml To Json
        $result = Form::xmlToJson($result);

        // DB Save
        $this->store($request, $result);

        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $result=null)
    {
        if($result){
            $custom = "";
            $_ARR = array();
            $_CUST = array();

            $_ARR = json_decode($result, 1);
            $_CUST['resultCode']=$_ARR['header']['resultCode'];
            $_CUST['resultMsg']=$_ARR['header']['resultMsg'];
            foreach($_ARR['body']['items'] as $k=>$datas){
                $_CUST['data'][]=$datas;
            }
            $custom = json_encode($_CUST, JSON_UNESCAPED_UNICODE);
        }

        $_DATA = Func::requestToData($request);
        $api = new Api();
        $api->setCollection($_DATA['operation']);
        $api->reqdate = date('Y-m-d H:i:s');
        $api->origin = $result;
        $api->custom = $custom;
        $api->save();

        $_RS['resultCode'] = "00";
        $_RS['resultMsg'] = "Save Success";

        return $_RS;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}