<?php 

namespace App\Controllers\Admin;

use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\User as M_User;
use Core\Controller;
use Core\View;

class Users extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "username" => ["required" => true, "username" => true, "minLength" => 3, "maxLength" => 15, "unique" => "user"],
        "email" => ["required" => true,  "email" => true, "unique" => "user"],
        "email_backup" => ["email" => true],
        "first_name" => ["required" => true, "names" => true, "minLength" => 3, "maxLength" => 15],
        "last_name" => ["required" => true, "names" => true, "minLength" => 3, "maxLength" => 15],
        "password" => ["required" => true, "password" => true, "minLength" => 8, "maxLength" => 30],
        "confirm_password" => ["required" => true,  "match" => "password"]
    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data["users"] = M_User::getAll();
        $message = $this->messages->getMassege("action_user");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function createAction(){
        $this->_data["form_errors"] = '';
        if(isset($_POST["create"])){
            $_POST["username"]          = static::FilterString($_POST['username']);
            $_POST["first_name"]        = static::FilterString($_POST['first_name']);
            $_POST["last_name"]         = static::FilterString($_POST['last_name']);
            $_POST["email"]             = static::FilterString($_POST['email']);
            $_POST["email_backup"]      = static::FilterString($_POST['email_backup']);
            $_POST["password"]          = static::FilterString($_POST['password']);
            $_POST["confirm_password"]  = static::FilterString($_POST['confirm_password']);

            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $user = new M_User();
                $user->username = $_POST["username"];
                $user->email = $_POST["email"];
                $user->email_backup = $_POST["email_backup"];
                $user->first_name = $_POST["first_name"];
                $user->last_name = $_POST["last_name"];
                $user->password = password_hash($_POST["password"],PASSWORD_DEFAULT);
                if($user->save()){
                    $this->messages->addMassege("create_user","The user is created successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("create_user","The user isn't created successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("create_user");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }


    public function updateAction(){
        $this->_data["form_errors"] = '';
        $id = $this->FilterInt($this->route_params["id"]);
        $this->_data["user"] = $user = M_User::getByPrimaryKey($id);
        unset(static::$rules["confirm_password"]["required"], static::$rules["password"]["required"]);
        if($user === false)
            $this->redirect("/admin/users");
        if(isset($_POST["update"])){
            $_POST["username"]          = static::FilterString($_POST['username']);
            $_POST["first_name"]        = static::FilterString($_POST['first_name']);
            $_POST["last_name"]         = static::FilterString($_POST['last_name']);
            $_POST["email"]             = static::FilterString($_POST['email']);
            $_POST["email_backup"]      = static::FilterString($_POST['email_backup']);
            $_POST["old_password"]      = static::FilterString($_POST['old_password']);
            $_POST["password"]          = static::FilterString($_POST['password']);
            $_POST["confirm_password"]  = static::FilterString($_POST['confirm_password']);
            $_POST["db_password"]  = $user->password;
            $_POST["old_username"]  = $user->username;
            $_POST["old_email"]  = $user->email;

            static::$rules["old_password"] = ["match_password" => "db_password"];
            static::$rules["username"]["unique"] = ["table" => "user", "except" => "old_username"];
            static::$rules["email"]["unique"] = ["table" => "user", "except" => "old_email"];

            if(!empty($_POST["password"]) || !empty($_POST["old_password"]) ){
                static::$rules["old_password"] = ["required"=> true]  + static::$rules["old_password"];
                static::$rules["password"] = ["required"=> true]  + static::$rules["password"];
                static::$rules["confirm_password"] = ["required"=> true]  + static::$rules["confirm_password"];
            }
 
            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $user->username = $_POST["username"];
                $user->email = $_POST["email"];
                $user->email_backup = $_POST["email_backup"];
                $user->first_name = $_POST["first_name"];
                $user->last_name = $_POST["last_name"];
                if(!empty($_POST["password"]))
                    $user->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                if($user->save()){
                    $this->messages->addMassege("update_user","The user is updated successfully");
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("update_user");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    
    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $user = M_User::getByPrimaryKey($id);
        if($user !== false){
            if($this->auth->getUserLogin()->getPrimaryKey() != $user->getPrimaryKey()){
                if($user->delete()){
                    $this->messages->addMassege("action_user","The User is deleted successfully");
                }
            }
        }
        static::redirect("/admin/users");

    }
}