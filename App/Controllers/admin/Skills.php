<?php 

namespace App\Controllers\Admin;

use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\Skill as M_Skill;
use App\Models\SkillCategory as M_SkillCategory;
use Core\Controller;
use Core\View;

class Skills extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "name" => ["required" => true,"minLength" => 2, "maxLength" => 100],
        "skill_category" => ["required" => true, "exists" => "skills_categories"],
        "ratio" => ["required" => true, "int" => true, "min" => 1 , "max" => 100],
    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data['skills'] = M_Skill::getAll();
        $message = $this->messages->getMassege("action_skill");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function createAction(){
        $this->_data["form_errors"] = '';
        $skills_categories = M_SkillCategory::getAll();
        if(isset($_POST["create"])){
            $_POST["name"] = static::FilterString($_POST['name']);
            $_POST["skill_category"] = static::FilterString($_POST['skill_category']);
            $_POST["ratio"] = static::FilterInt($_POST['ratio']);
            if($skills_categories !== false){
                foreach($skills_categories as $categ){
                    $_POST["skills_categories"][] = $categ->getPrimaryKey();
                }
            }else
                $_POST["skills_categories"] = [];

            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $skill = new M_Skill();
                $skill->name = $_POST["name"];
                $skill->skill_category = $_POST["skill_category"];
                $skill->ratio = $_POST["ratio"];
                unset($_POST["skills_categories"]);

                if($skill->save()){
                    $this->messages->addMassege("create_skill","The Skill is created successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("create_skill","The Skill isn't created successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("create_skill");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        $this->_data["skills_categories"] = $skills_categories;
        View::render();
    }


    public function updateAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $this->_data["form_errors"] = '';
        $this->_data['skill'] = $skill = M_Skill::getByPrimaryKey($id);
        if($skill === false)
            static::redirect("/admin/skills");
        $skills_categories = M_SkillCategory::getAll();
        if(isset($_POST["update"])){
            $_POST["name"] = static::FilterString($_POST['name']);
            $_POST["skill_category"] = static::FilterString($_POST['skill_category']);
            $_POST["ratio"] = static::FilterInt($_POST['ratio']);
            if($skills_categories !== false){
                foreach($skills_categories as $categ){
                    $_POST["skills_categories"][] = $categ->getPrimaryKey();
                }
            }else
                $_POST["skills_categories"] = [];

            $validate = new Validate($_POST, static::$rules);
            if($validate->isValidate()){
                $skill->name = $_POST["name"];
                $skill->skill_category = $_POST["skill_category"];
                $skill->ratio = $_POST["ratio"];
                unset($_POST["skills_categories"]);
                if($skill->save()){
                    $this->messages->addMassege("update_skill","The Skill is updated successfully");
                    static::Refresh();
                }else{
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
            }
        }
        $message = $this->messages->getMassege("update_skill");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        $this->_data["skills_categories"] = $skills_categories;
        View::render();
    }

    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $skill = M_Skill::getByPrimaryKey($id);
        if($skill !== false){
            if($skill->delete()){
                $this->messages->addMassege("action_skill","The Skill is deleted successfully");
            }
        }
        static::redirect("/admin/skills");
    }
}