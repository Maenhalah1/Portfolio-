<?php 

namespace Core;

use App\Lib\ApiCall;
use App\Lib\Authentication;
use App\Lib\Cookies;
use App\Lib\SessionManager;
use App\Lib\Database;
use App\Lib\Messenger;
use App\Lib\Services;
use App\Models\Visitors;
use Config\Config;

abstract class Controller{

    protected $route_params = []; // Routes Paramters
    protected $_data = [];
    protected $_registry ;

    // define Route Paramters from any controller in (app/controller) directory
    public function __construct($params){
        $this->route_params = $params;
        View::setParams($params);
        View::setData($this->_data);
        $this->loadRegistryObjects();
    }

    public function __call($name, $arguments){
        $method = $name . "Action";
        if(method_exists($this, $method)){
            if($this->before() !== false){
                call_user_func_array([$this,$method],$arguments);
                $this->after();
            }
        }else{
            throw new \Exception("", "404");
        }
    }

    public function __get($name){
        return isset($this->_registry->$name) ? $this->_registry->$name : "";
    }

    public function before(){}

    public function after(){}

    private function loadRegistryObjects(){
        $this->_registry = Registry::getInstance();
        $this->_registry->session =  new SessionManager();
        $this->session->start();
        if (!$this->session->checkFingerprint())
            $this->session->sessionDestroy();
        $this->_registry->messages =  Messenger::getInstance($this->session);
        $this->_registry->auth =  Authentication::getInstance($this->session);
        $this->_registry->db = new Database(Config::DB_HOST, Config::DB_NAME, Config::DB_USER, Config::DB_PASSWORD);
        Model::setDB($this->db);

    }

    protected function saveVisitorsInformation(){
        if(!Cookies::exists("visited")){
            $visitor = new Visitors();
            $visitor->ip_address = Services::getUserIPAddress();
            $ipInfo = ApiCall::getClientIPInfo($visitor->ip_address);
            $visitor->country = $ipInfo["country"];
            $visitor->city = $ipInfo["city"];
            $visitor->lat = $ipInfo["lat"];
            $visitor->lon = $ipInfo["lon"];
            $deviceInfo = Services::getClientDeviceInfo();
            $visitor->os = $deviceInfo["os"];
            $visitor->device_type = $deviceInfo["device_type"];
            $visitor->device_info = $deviceInfo["device_info"];
            $visitor->save();
            Cookies::set("visited", true, 60*60*24*30*12);
        }
    }

}