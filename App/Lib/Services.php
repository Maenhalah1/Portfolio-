<?php 

namespace App\Lib;
class Services{


    public static function encrypt($data, $encryption_method, $key, $iv){
        $iv_encryption = substr(hash("sha256", $iv), 0, 16);
        
        $output = openssl_encrypt($data, $encryption_method, $key, $options = 0, $iv_encryption);
        return  base64_encode($output);
    }

    public static function decrypt($data, $encryption_method, $key, $iv){
        $data = base64_decode($data);
        $iv_encryption = substr(hash("sha256", $iv), 0, 16);
        $output = openssl_decrypt($data, $encryption_method, $key, $options = 0, $iv_encryption);
        return  $output;
    }


    public static function getUserIPAddress(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];

        return $ipaddress;
    }

    public static function getClientBrowserName(){
        $userAgent = $_SERVER["HTTP_USER_AGENT"];
        $bname = 'unknown';
        if(preg_match('/MSIE/i',$userAgent) && !preg_match('/Opera/i',$userAgent)){
            $bname = 'Internet Explorer';
          }elseif(preg_match('/Firefox/i',$userAgent)){
            $bname = 'Mozilla Firefox';
          }elseif(preg_match('/OPR/i',$userAgent)){
            $bname = 'Opera';
          }elseif(preg_match('/Edge/i',$userAgent) || preg_match('/Edg/i',$userAgent)){
            $bname = 'Micrsoft Edge';
          }elseif(preg_match('/Chrome/i',$userAgent) && !preg_match('/Edge/i',$userAgent)){
            $bname = 'Google Chrome';
          }elseif(preg_match('/Safari/i',$userAgent) && !preg_match('/Edge/i',$userAgent)){
            $bname = 'Apple Safari';
          }elseif(preg_match('/Netscape/i',$userAgent)){
            $bname = 'Netscape';
          }elseif(preg_match('/Trident/i',$userAgent)){
            $bname = 'Internet Explorer';
          }
          return $bname;
    }

    public static function getClientDeviceInfo(){
        $userAgent = $_SERVER["HTTP_USER_AGENT"];
        $device["os"] = "unknown";
        $allOs = [
            '/windows phone/i'      =>  'Windows Phone',
            '/nokia/i'              =>  'Nokia Phone',
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh/i'          =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/bb/i'                 =>  'BlackBerry',
            '/webos/i'              =>  'Mobile',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
        ];
        foreach($allOs as $osPattern => $osName){
            if(preg_match($osPattern, $userAgent)){
                $device["os"] = $osName;
                break;
            }
        }
        $device["device_info"] = "unknown";
        if(preg_match("/^Mozilla.*?\((.*?)\)/i",$userAgent,$result)){
          $device["device_info"] = $result[1];
        }
        $device["device_type"] = preg_match("/iphone|ipod|ipad|android|blackberry|phone|webos|mobile/i",$_SERVER["HTTP_USER_AGENT"]) ? "m" : "c";

        return $device;
    }



        
}