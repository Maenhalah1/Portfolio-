<?php 

namespace App\Controllers\Admin;

use Core\Controller;
use Core\View;

class Auth extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    public function before(){
        if($this->route_params["action"] !== "logout"){
            if($this->auth->isLogin()){
                $this->redirect("/admin/home");
            }
        }else{
            if(!$this->auth->isLogin()){
                $this->redirect("/admin/auth");
            }
        }
    }
    
    public function after(){ }

    public function indexAction(){
        $this->redirect("auth/login");
    }

    public function loginAction(){
        if(isset($_POST["login"])){
            $username = $this->FilterString($_POST["username"]);
            $password = $this->FilterString($_POST["password"]);
            if($this->auth->login($username, $password)){
                $this->redirect("/admin/home");
            }else{
                $this->_data["form_errors"] = 'Username or Email or Password aren\'t Correct';
            }
        }
        View::render();
    }

    public function logoutAction(){
        $this->auth->logout();
        $this->redirect("/admin/auth");
    }
}