<?php 

namespace Core;

class Registry{

    private static $instance;

    private function __construct(){} // cant create direct object from it
    private function __clone(){} // cant clone object

    public static function getInstance(){
        if(self::$instance == null)
            self::$instance = new self();
        return self::$instance;
    }

}