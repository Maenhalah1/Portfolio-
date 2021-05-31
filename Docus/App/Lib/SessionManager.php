<?php 

namespace App\Lib;

use Config\Config;
use SessionHandler;

class SessionManager extends SessionHandler{
	
	private $sessionName = "SESS";
	private $sessionMaxLifeTime = 0;
	private $sessionSSL = false;
	private $sessionHTTPOnly = true;
	private $sessionPath = '/';
	private $sessionDomain = '';
	private $sessionSavepath = Config::SESSIONS_SAVE_PATH;
	private $sessionMaxTimevalid = 10 ; // 10 Minutes

	// Encryption Properties
    private $encryption_method = "AES-256-CBC";
    private $encryption_key = 'AKDSsmdkas219JC#!21XSFSg%$@!3HMkl54@uI312jh#dX2133XSA#a3sf&^adDSA';
    private $encryption_iv = "LMsdaB5&#245_9LCVOF3-2-VZXYScxzATDP443212TEdas95dfs4323";

	public function __construct() {

		ini_set('session.use_cookies', 1);
		ini_set('session.use_only_cookies', 1);
		ini_set('session.use_trans_sid', 0);
		ini_set('session.save_handler', 'files');

		session_name($this->sessionName);
		session_save_path($this->sessionSavepath);
		session_set_cookie_params(
			$this->sessionMaxLifeTime, $this->sessionPath,
			$this->sessionDomain	 , $this->sessionSSL,
			$this->sessionHTTPOnly
		);
        session_set_save_handler($this,true);
	}


    public function start(){
        if(session_id() === ''){
           if(session_start()){
               $this->set_session_start_time();
               if(!$this->check_session_validty()){
                   $this->generate_new_session();
                   $this->generate_fingerprint();
               }
           }
        }
    }

    private function set_session_start_time(){
        if(!isset($this->session_start_time)){
            $this->session_start_time = time();
        }
    }

    private function check_session_validty(){
	    return ( time() - $this->session_start_time ) < ($this->sessionMaxTimevalid * 60) ? true : false;
    }

    private function generate_new_session(){
	    $this->session_start_time = time();
	    return session_regenerate_id(true);
    }

    private function generate_fingerprint(){
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->cipherKey = openssl_random_pseudo_bytes(32);
        $sessionID = session_id();
        $this->finger_print = hash("sha256",$userAgent . $this->cipherKey . $sessionID);
    }

    public function checkFingerprint(){
	    if(!isset($this->finger_print)){
	       $this->generate_fingerprint();
        }
	    $currentFinger = hash("sha256" , $_SERVER['HTTP_USER_AGENT'] . $this->cipherKey . session_id());

	    return $this->finger_print == $currentFinger;
    }


    public function sessionDestroy(){
        session_unset(); // unset all data
        setcookie( // Destroy Cookie
            $this->sessionName , '' , time() - 1000,
            $this->sessionPath , $this->sessionDomain,
            $this->sessionSSL  , $this->sessionHTTPOnly
        );
        session_destroy(); // destroy session
    }


    public function __set($key, $value){
        $this->set($key,$value);
    }

    public function __get($key){
        return $this->get($key);
    } 

    public function __isset($key){
        return isset($_SESSION[$key]) ? true : false;
    } 

    public function __unset($key){
        if(isset($_SESSION[$key])) 
            unset($_SESSION[$key]);
    }


    public function set($session_id, $session_data)
    {
        $_SESSION[$session_id] = $this->encrypt_session_data($session_data);
    }  


    public function get($session_id)
    {
        $encrypted_data = $_SESSION[$session_id];
        if($encrypted_data == ""){
            return "";
        }else{
            return $this->decrypt_session_data($encrypted_data);
        }
    }  

    public function encrypt_session_data($data){
        return Services::encrypt(serialize($data),$this->encryption_method, $this->encryption_key, $this->encryption_iv);
    }

    public function decrypt_session_data($encrypted_data){
        return @unserialize(Services::decrypt($encrypted_data,$this->encryption_method, $this->encryption_key, $this->encryption_iv));
    }


}





