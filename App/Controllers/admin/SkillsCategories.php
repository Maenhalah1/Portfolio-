<?php 

namespace App\Controllers\Admin;

use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\SkillCategory as M_SkillCategory;
use Core\Controller;
use Core\View;

class SkillsCategories extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "name" => ["required" => true, "names" => true, "minLength" => 3, "maxLength" => 40, "unique" => "SkillCategory"],
    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data["categories"] = M_SkillCategory::getAll();
        $message = $this->messages->getMassege("action_skill_category");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function createAction(){
        $this->_data["form_errors"] = '';
        if(isset($_POST["create"])){
            $_POST["name"] = static::FilterString($_POST['name']);

            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $skillCateg = new M_SkillCategory();
                $skillCateg->name = $_POST["name"];

                if($skillCateg->save()){
                    $this->messages->addMassege("create_skill_category","The Skill Category is created successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("create_skill_category","The Skill Category isn't created successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("create_skill_category");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);

        View::render();
    }

    public function updateAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $this->_data['skillCateg'] = $skillCateg = M_SkillCategory::getByPrimaryKey($id);
        $this->_data["form_errors"] = '';
        if(isset($_POST["update"])){
            $_POST["name"] = static::FilterString($_POST['name']);

            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $skillCateg->name = $_POST["name"];
                if($skillCateg->save()){
                    $this->messages->addMassege("update_skill_category","The Skills Category is updated successfully");
                    static::Refresh();
                }else{
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("update_skill_category");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $skillCateg = M_SkillCategory::getByPrimaryKey($id);
        if($skillCateg !== false){
            if($skillCateg->delete()){
                $this->messages->addMassege("action_skill_category","The Skills Category is deleted successfully");
            }
        }
        static::redirect("/admin/skills_categories");

    }
}