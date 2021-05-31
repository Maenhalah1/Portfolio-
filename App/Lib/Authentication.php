<?php 
namespace App\Lib;

use App\Models\User;

class Authentication{

    private $user = null;
    private $login = false;

    private static $instance;
    private $_session;

    private function __construct($seesion){
        $this->_session = $seesion;
        $this->checkLogin();

    } // cant create direct object from it
    private function __clone(){} // cant clone object

    public static function getInstance(SessionManager $session){
        if(self::$instance == null)
            self::$instance = new self($session);
        return self::$instance;
    }

    public function getUserLogin(){
        return $this->user;
    }

    public function login($username,$password){
        $user = User::where("username = :u OR email = :u", [":u" => $username]);
        if($user !== false){
            $user = $user[0];
            if(password_verify($password, $user->password)){
                $this->_session->user = $this->user = $user;
                $this->login = true;
                return true;
            }
        }
        return false;
    }

    public function isLogin(){
        return $this->login;
    }

    private function checkLogin(){
        if(isset($this->_session->user) && is_object($this->_session->user)){
            $this->user = $this->_session->user;
            $this->login = true;
        }
    }

    public function logout(){
        if($this->isLogin()){
            $this->_session->sessionDestroy();
        }
    }

}