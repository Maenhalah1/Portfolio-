<?php

namespace App\Lib;
use App\Lib\SessionManager;

class Messenger{

    const SUCCESS_MASSEGE   = "success";
    const DANGER_MASSEGE    = "danger";
    const WARNING_MASSEGE   = "warning";
    const INFO_MASSEGE      = "dark";

    private static $instance;
    private $_session;

    private function __construct($seesion){
        $this->_session = $seesion;

    } // cant create direct object from it
    private function __clone(){} // cant clone object

    public static function getInstance(SessionManager $session){
        if(self::$instance == null)
            self::$instance = new self($session);
        return self::$instance;
    }

    private function checkifMassegeExists($name){
        return isset($this->_session->$name);
    }

    public function addMassege($name, $msg, $Messagetype = self::SUCCESS_MASSEGE){
        $name = $name . "_massege";
        if(!$this->checkifMassegeExists($name)){
            $data = [$msg , $Messagetype];
            $this->_session->$name = $data;
            unset($data);
        }
    }

    public function addMultiMassege(array $arrMsgs, $type = self::SUCCESS_MASSEGE){
        foreach($arrMsgs as $name => $msg){
            $name = $name . "_massege";
            if(!$this->checkifMassegeExists($name)){
                $data = [$msg , $type];
                $this->_session->$name = $data;
                unset($data);
            }
        }
    }

    public function getMassege($name){
        $name = $name . "_massege";
        if($this->checkifMassegeExists($name)){
            $massege = $this->_session->$name;
            unset($this->_session->$name);
            return $massege;
        }
        return false;
    }

}


?>