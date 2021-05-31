<?php 
namespace Core;


use Config\Config;
use Exception;

Class View{
    use \App\Lib\Helper;

    private static $route_params = [];
    private static $_data = [];

    public static $css = [];
    public static $js = [];


    public static function setParams(array $params){
        self::$route_params = $params;
    }

    public static function setData(array &$data){
        self::$_data = &$data;
    }



    public static function render($file_path = null){
        if(!isset(self::$route_params["controller"]))
            self::$route_params["controller"] = '';
        if(!isset(self::$route_params["action"]))
            self::$route_params["action"] = '';        
        if(!isset(self::$route_params["subDir"]))
            self::$route_params["subDir"] = '';

        $file =  $file_path === null ? self::getFile() : $file_path;
        if(file_exists($file)){                   
            extract(self::$_data);
            require Config::VIEWS_PATH . DS . "Include" . DS . "header.view.php";
            require $file;
            require Config::VIEWS_PATH . DS . "Include" . DS . "footer.view.php";
        }else{
            throw new Exception("No View Found", 505);
        }  
    }

    public static function LoadFile($filePath){
        $path = Config::VIEWS_PATH . DS . $filePath;
        if(file_exists($path))
            require_once $path;
    } 

    private static function getFile(){
        $file = Config::VIEWS_PATH;
        $file .= self::$route_params["subDir"] !== null ? self::$route_params["subDir"] . DS  : null;
        $file .= self::$route_params["controller"] . DS . self::$route_params["action"] . ".view.php";
        return $file;
    }

  
    public static function loadHeaderResourse(){
        $file = "Include" . DS . "header_resources" . DS;
        $file .=  self::$route_params["subDir"] !== null ? self::$route_params["subDir"] . DS  : null;
        $file .= self::$route_params["controller"] . DS . self::$route_params["action"] . ".head.php";
        self::LoadFile($file);
    }
    public static function loadFooterResourse(){
        $file = "Include" . DS . "footer_resources" . DS;
        $file .=  self::$route_params["subDir"] !== null ? self::$route_params["subDir"] . DS  : null;
        $file .= self::$route_params["controller"] . DS . self::$route_params["action"] . ".foot.php";
        self::LoadFile($file);
    } 

    public static function getCustomPageCssFiles(){
        $path = Config::CSS_PATH . (self::$route_params["subDir"] !== null ? self::$route_params["subDir"] . DS  : null);
        $path .= (self::$route_params["controller"]) . DS . self::$route_params["action"];
        $path = trim($path,"/\\");

        if(is_dir($path)){
            $files = glob($path . DS . "*");
            if(!empty($files))
                return $files;
        }
        return -1;
        
    }
    public static function getCustomPageJsFiles(){
        $path = Config::JS_PATH . (self::$route_params["subDir"] !== null ? self::$route_params["subDir"] . DS  : null);
        $path .= self::$route_params["controller"] . DS . self::$route_params["action"];
        $path = trim($path,"/\\");
        if(is_dir($path)){
            $files = glob($path . DS . "*");
            if(!empty($files))
                return $files;
        }
        return -1;
    } 

    

}