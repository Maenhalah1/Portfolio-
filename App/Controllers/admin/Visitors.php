<?php 

namespace App\Controllers\Admin;

use App\Models\Visitors as M_Visitors;
use Core\Controller;
use Core\View;

class Visitors extends Controller{
    use \App\Lib\Helper;

    public function before(){
        if(!$this->auth->isLogin()){
            $this->redirect("/admin/auth");
        }
    }
    public function after(){}

    public function indexAction(){
        $this->_data["visitors"] = M_Visitors::getAll();
        View::render();
    }


}