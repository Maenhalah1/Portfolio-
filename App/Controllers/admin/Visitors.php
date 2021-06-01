<?php 

namespace App\Controllers\Admin;

use App\Models\Visitors as M_Visitors;
use Core\Controller;
use Core\View;

class Visitors extends Controller{
    use \App\Lib\Helper;
    use \App\Lib\Filters;

    public function before(){
        if(!$this->auth->isLogin()){
            $this->redirect("/admin/auth");
        }
    }
    public function after(){}

    public function indexAction(){
        $this->_data["visitors"] = M_Visitors::getAll();
        $message = $this->messages->getMassege("action_visitor");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $visitor = M_Visitors::getByPrimaryKey($id);
        if($visitor !== false){
            if($visitor->delete()){
                $this->messages->addMassege("action_visitor","The Visitor is deleted successfully");
            }
        }
        
        static::redirect("/admin/visitors");
    }


}