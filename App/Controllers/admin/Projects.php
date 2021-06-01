<?php 

namespace App\Controllers\Admin;

use App\Lib\Files;
use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\Project as M_Project;
use App\Models\ProjectPhoto;
use Core\Controller;
use Core\View;

class Projects extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "project_name" => ["required" => true,  "minLength" => 2, "maxLength" => 40],
        "project_link" => ["url" => true],
        "project_video_link" => ["urlYoutubeEmbed" => true],
        "project_description" => ["required" => true, "minLength" => 5, "maxLength" => 1500],
        "client_name" => ["names" => true, "minLength" => 2, "maxLength" => 70],

    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data['projects'] = M_Project::getAll();
        $message = $this->messages->getMassege("action_project");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }

    public function createAction(){
        $this->_data["form_errors"] = '';
        $this->_data["files_errors"] = '';
        if(isset($_POST["create"])){
            $_POST["project_name"]          = static::FilterString($_POST['project_name']);
            $_POST["project_link"]          = static::FilterString($_POST['project_link']);
            $_POST["project_video_link"]    = static::FilterString($_POST['project_video_link']);
            $_POST["project_description"]   = static::FilterString($_POST['project_description']);
            $_POST["client_name"]           = static::FilterString($_POST['client_name']);

            $validate = new Validate($_POST, static::$rules);
            $files = new Files($_FILES["project_photos"],true,1,100);
            $files->filesValidation();
            if($validate->isValidate() && $files->filesValidation()){
                $project = new M_Project();
                $project->project_name = $_POST["project_name"];
                $project->project_link = $_POST["project_link"];
                $project->project_video_link = $_POST["project_video_link"];
                $project->project_description = $_POST["project_description"];
                $project->client_name = $_POST["client_name"];

                if($project->save()){
                    $uploadPath = $project->getRootPhotosPath();
                    Files::createDirectory($uploadPath);
                    for($i=0;$i<$files->getNumberFilesUpload();$i++){
                        $photo = new ProjectPhoto();
                        $photo->photo_name = $files->getFileNewName($i);
                        $photo->project = $project->getPrimaryKey();
                        $photo->save();
                    }
                    $files->upload($uploadPath);
                    $this->messages->addMassege("create_project","The Project is created successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("create_project","The Project isn't created successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
                $this->_data["files_errors"] = $files->getFilesErrors();
            }
        }
        $message = $this->messages->getMassege("create_project");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }


    public function updateAction(){
        $this->_data["form_errors"] = '';
        $this->_data["files_errors"] = '';
        $id = $this->FilterInt($this->route_params["id"]);
        $this->_data['project'] = $project = M_Project::getByPrimaryKey($id);
        if($project === false)
            $this->redirect("/admin/projects");
        if(isset($_POST["update"])){
            $_POST["project_name"]          = static::FilterString($_POST['project_name']);
            $_POST["project_link"]          = static::FilterString($_POST['project_link']);
            $_POST["project_video_link"]    = static::FilterString($_POST['project_video_link']);
            $_POST["project_description"]   = static::FilterString($_POST['project_description']);
            $_POST["client_name"]           = static::FilterString($_POST['client_name']);

            $validate = new Validate($_POST, static::$rules);
            $files = new Files($_FILES["project_photos"],true,1,100);
            $files->filesValidation();
            if($validate->isValidate() && $files->filesValidation()){
                $project->project_name = $_POST["project_name"];
                $project->project_link = $_POST["project_link"];
                $project->project_video_link = $_POST["project_video_link"];
                $project->project_description = $_POST["project_description"];
                $project->client_name = $_POST["client_name"];
                $result = $project->save();

                if($files->getNumberFilesUpload() > 0){
                    $result = true;
                    ProjectPhoto::deleteWithWhere("project = :project_id", [":project_id" => $id]);
                    $uploadPath = $project->getRootPhotosPath();
                    Files::deleteDirectory($uploadPath);
                    Files::createDirectory($uploadPath);
                    for($i=0;$i<$files->getNumberFilesUpload();$i++){
                        $photo = new ProjectPhoto();
                        $photo->photo_name = $files->getFileNewName($i);
                        $photo->project = $project->getPrimaryKey();
                        $photo->save();
                    }
                    $files->upload($uploadPath);
                }
                if($result){
                    $this->messages->addMassege("create_project","The Project is updated successfully");
                    static::Refresh();
                }
                
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
                $this->_data["files_errors"] = $files->getFilesErrors();
            }
        }
        $message = $this->messages->getMassege("create_project");
        if($message !== false)
            $this->_data["user_message"] = $message;
        unset($message);
        View::render();
    }



    public function deleteAction(){
        $id = $this->FilterInt($this->route_params["id"]);
        $project = M_Project::getByPrimaryKey($id);
        if($project !== false){
            if($project->delete()){
                $uploadPath = $project->getRootPhotosPath();
                ProjectPhoto::deleteWithWhere("project = :project_id", [":project_id" => $id]);
                Files::deleteDirectory($uploadPath);
                $this->messages->addMassege("action_project","The Project is deleted successfully");
            }
        }
        static::redirect("/admin/projects");
    }
}