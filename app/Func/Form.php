<?php
/**
 *  Title : Form | Honeypigman@gmail.com
 *  Date : 2021.02.26
 * 
 */

namespace App\Func;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Form extends Eloquent
{
    /**
     * Json To Data
     *  PARAM[1] : Api Code
     *  PARAM[2] : Json Return Data Array or Object
     */
    static function getData($api_code, $isArray=1){

        $arr = json_decode(file_get_contents('storage/form/'.$api_code.'.json'), $isArray);

        return $arr;
    }

    /**
     * set Query String
     *  PARAM[1] : Array
     */
    static function setQueryString($array){
        $query_string="";
        foreach($array['data'] as $name=>$data){
            $query_string.=$name."=".$data."&";
        }
        return substr($query_string,0,-1);;
    }

    /**
     * xml To Json
     *  PARAM[1] : xml
     */
    static function xmlToJson($str){
        $getJson = "";
        $getXml = simplexml_load_string($str);
        $getJson = json_encode($getXml, JSON_UNESCAPED_UNICODE);

        return $getJson;
    }
} 