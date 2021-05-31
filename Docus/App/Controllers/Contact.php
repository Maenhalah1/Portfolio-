<?php 
namespace App\Controllers;

use App\Lib\Messenger;
use App\Lib\Services;
use Core\Controller;
use Core\View;
use \App\Lib\Validate;
use App\Mailer;
use App\Models\Users;

class Contact extends Controller{
    use \App\Lib\Filters;
    use \App\Lib\Helper;

    private static $rules = [
        "first_name" => ["required" => true, "names" => true, "minLength" => 3, "maxLength" => 15],
        "last_name" => ["required" => true, "names" => true, "minLength" => 3, "maxLength" => 15],
        "email" => ["required" => true,  "email" => true],
        "subject" => ["required" => true,  "minLength" => 3, "maxLength" => 30],
        "message" => ["required" => true,  "minLength" => 5, "maxLength" => 250]
    ];



    public function before(){}
    public function after(){}

    public function indexAction(){
        $this->_data["form_errors"] = '';
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $_POST["first_name"]    = static::FilterString($_POST['first_name']);
            $_POST["last_name"]     = static::FilterString($_POST['last_name']);
            $_POST["email"]         = static::FilterString($_POST['email']);
            $_POST["subject"]       = static::FilterString($_POST['subject']);
            $_POST["message"]       = static::FilterString($_POST['message']);

            $validate = new Validate($_POST,static::$rules);
            if($validate->isValidate()){
                $mailer = new Mailer();
                if($mailer->send($_POST["email"], "maensadeq1999mh@gmail.com",$_POST["subject"], $_POST["message"],null,true)){
                    $this->messages->addMassege("contact_send_status","The message is send successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("contact_send_status","The message was not sent successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("contact_send_status");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }


}