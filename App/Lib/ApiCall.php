<?php 

namespace App\Lib;

use Exception;

class ApiCall{

    public static function getClientIPInfo($ip){
        $result = [];
        $result["country"] = '';
        $result["city"] = '';
        $result["lat"] = '';
        $result["lon"] = '';
        if($ip !== ''){
            try{
                $url = "http://ip-api.com/json/" . $ip;
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL,$url);
                curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
                $data = json_decode(curl_exec($curl));
                $result["country"] = @$data->country;
                $result["city"] = @isset($data->city) ? $data->city : 
                    (isset($data->regionName) ? $data->regionName :
                     (isset($data->region) ? $data->region : "unknown"));
                $result["lat"] = @$data->lat;
                $result["lon"] = @$data->lon;
            }catch(Exception $e){
                
            }
        }
        return $result;
    }



        
}