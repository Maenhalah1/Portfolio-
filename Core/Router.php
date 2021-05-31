<?php

namespace Core;

use Config\Config;
use Exception;

class Router {
    
    // Routing Table 
    protected $routes = [];
    // Url Paramters
    protected $params = [];

    protected const CONTROLLER_NAMESPACE = "App\Controllers";




    public function add($route, array $params = []){

        // Convert all forword slash (/) To skip forward slash (\/)
        $route = preg_replace("/\//",'\\/',$route);

        // Convert Main Url Varibales To RegEx Pattern Like This => {Controller} To (?P<Controller>[a-z-_])
        $route = preg_replace('/\{([a-z]+)\}/i', '(?P<$1>[a-z_-]+)', $route);

        //Convert Custom Url Varibales to RegEx Pattern Like This => {id:\d+} to (?P<id>\d+)
        $route = preg_replace('/\{([a-z]+)\:([^\{]+)}/i', '(?P<\1>\2)', $route);

        $route = "/^" . $route . "$/i";

        $this->routes[$route] = $params;

    }

    public function getRoutes(){
        return $this->routes;
    }

    public function match($url){
        $url = trim($url,"/\\");
        foreach ($this->routes as $route => $params){
            if(preg_match($route, $url, $matches)){
                foreach($matches as $key => $value){
                    if(is_string($key)){
                        $params[$key] = $value;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;

    }

    public function dispatch($url){

        $url = $this->removeQueryStringVariabales($url);
        if(!Config::ACTIVE_APP){
            throw new \Exception("", "500");
        }else{
            if($this->match($url)){
                $this->params["controller"] = $controller = $this->convertToStudlyCaps($this->params["controller"]);
                $controller =  $this->getControllerNamespace() . $controller;
                $this->initizeSubDirectory();
                if(class_exists($controller)){
                    $this->params["action"] = $action = $this->convertToCamelCase($this->params["action"]);
                    $controller_obj = new $controller($this->params);
                    if(preg_match("/action$/i",$action) == 0){
                        if(is_callable([$controller_obj,$action]))
                            $controller_obj->$action();
                        else
                            throw new Exception("Not Callable", 404);            
                    }else{
                        throw new Exception(" There is Action is method name", 404);            
                    }
                }else{
                    throw new Exception("controller not exists", 404);            
                }
            }else{
                throw new Exception("not match", 404);            
            }
        }

    }

    public function getParams(){
        return $this->params;
    }

    public function convertToStudlyCaps($str){
        return str_replace(" ","", ucwords(str_replace("_"," ",$str)));
    }

    public function convertToCamelCase($str){
        return lcfirst($this->convertToStudlyCaps($str));
    }

    public function removeQueryStringVariabales($url){
        $parts = explode("&",$url,2);

        if(strpos($parts[0],"=") === false){
            $url = $parts[0];
        }else{
            $url = '';
        }
       return $url;
    }

    public function getControllerNamespace(){
        $namespace = self::CONTROLLER_NAMESPACE . '\\';
        if(array_key_exists("namespace",$this->params)){
            $namespace .=  $this->params['namespace'] . "\\";
            
        }
        return $namespace;
    }

    public function initizeSubDirectory(){
        $this->params["subDir"] = null;
       if(array_key_exists("namespace",$this->params)){
            $this->params["subDir"] = str_replace("\\", DS , $this->params["namespace"]);
       }
    }

}