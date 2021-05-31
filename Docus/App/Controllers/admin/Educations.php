<?php 

namespace App\Controllers\Admin;

use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\Education as M_Education;
use Core\Controller;
use Core\View;

class Educations extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "degree" => ["required" => true, "enCharsNumber" => true, "minLength" => 2, "maxLength" => 40],
        "university" => ["required" => true, "minLength" => 2, "maxLength" => 40],
        "major" => ["required" => true, "enCharsNumber" => true, "minLength" => 2, "maxLength" => 40],
        "college" => ["required" => true, "minLength" => 2, "maxLength" => 40],
        "degree_abbreviation" => ["required" => true, "minLength" => 2, "maxLength" => 40],
        "start_date" => ["required" => true, "date" => true, "maxDate" => "now"],
        "end_date" => ["required" => true, "date" => true ,"minDate" => "start_date"],

    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data['educations'] = M_Education::getAll();
        $message = $this->messages->getMassege("action_education");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function createAction(){
        $this->_data["form_errors"] = '';
        if(isset($_POST["create"])){
            $_POST["degree"] = static::FilterString($_POST['degree']);
            $_POST["university"] = static::FilterString($_POST['university']);
            $_POST["major"] = static::FilterString($_POST['major']);
            $_POST["college"] = static::FilterString($_POST['college']);
            $_POST["degree_abbreviation"] = static::FilterString($_POST['degree_abbreviation']);
            $_POST["start_date"] = static::FilterString($_POST['start_date']);
            $_POST["end_date"] = static::FilterString($_POST['end_date']);
            


            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $education = new M_Education();
                $education->degree = $_POST["degree"];
                $education->university = $_POST["university"];
                $education->major = $_POST["major"];
                $education->college = $_POST["college"];
                $education->degree_abbreviation = $_POST["degree_abbreviation"];
                $education->start_date = $_POST["start_date"];
                $education->end_date = $_POST["end_date"];

                if($education->save()){
                    $this->messages->addMassege("create_education","The Education is created successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("create_education","The Education isn't created successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("create_education");
        if($message !== false)
            $this->_data["user_message"] = $message;
        View::render();
    }


    public function updateAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $this->_data["form_errors"] = '';
        $this->_data["education"] = $education = M_Education::getByPrimaryKey($id);
        if($education === false){
            static::redirect("/admin/educations");
        }

        if(isset($_POST["update"])){
            $_POST["degree"] = static::FilterString($_POST['degree']);
            $_POST["university"] = static::FilterString($_POST['university']);
            $_POST["major"] = static::FilterString($_POST['major']);
            $_POST["college"] = static::FilterString($_POST['college']);
            $_POST["degree_abbreviation"] = static::FilterString($_POST['degree_abbreviation']);
            $_POST["start_date"] = static::FilterString($_POST['start_date']);
            $_POST["end_date"] = static::FilterString($_POST['end_date']);
            


            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $education->degree = $_POST["degree"];
                $education->university = $_POST["university"];
                $education->major = $_POST["major"];
                $education->college = $_POST["college"];
                $education->degree_abbreviation = $_POST["degree_abbreviation"];
                $education->start_date = $_POST["start_date"];
                $education->end_date = $_POST["end_date"];


                if($education->save()){
                    $this->messages->addMassege("update_education","The Education is updated successfully");
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("update_education");
        if($message !== false)
            $this->_data["user_message"] = $message;
        View::render();

    }

    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $education = M_Education::getByPrimaryKey($id);
        if($education !== false){
            if($education->delete()){
                $this->messages->addMassege("action_education","The Education is deleted successfully");
            }
        }
        static::redirect("/admin/educations");
    }
}