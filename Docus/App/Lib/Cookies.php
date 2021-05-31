<?php 

namespace App\Lib;
class Cookies{


    public static function set($name, $value, $expire){
        setcookie($name, $value , time() + $expire);
    }

    public static function get($name){
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
    }

    public static function exists($name){
        return isset($_COOKIE[$name]);
    }
  


        
}