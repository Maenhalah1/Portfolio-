<?php 

namespace App\Controllers\Admin;

use Core\Controller;
use Core\View;

class Home extends Controller{
    use \App\Lib\Helper;

    public function before(){
        if(!$this->auth->isLogin()){
            $this->redirect("/admin/auth");
        }
    }
    public function after(){}

    public function indexAction(){
        View::render();

    }


}