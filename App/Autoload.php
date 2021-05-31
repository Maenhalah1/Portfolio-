<?php 

namespace App;

class Autoload {

    public static function autoloading($class){
        $root = dirname(__DIR__);
        $class = str_replace("\\",DS,$class) . ".php";
        $file = $root . DS . $class;
        if(is_readable($file)){
            require_once $file;
        }else{
            // echo "Unexipted Error: " . $class ." Class not Found";
            // die;
        }
    }
}
spl_autoload_register(__NAMESPACE__ . "\Autoload::autoloading");