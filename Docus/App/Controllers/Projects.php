<?php 
namespace App\Controllers;

use App\Models\Project;
use App\Models\ProjectPhoto;
use Core\Controller;
use Core\View;

class Projects extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    public function before(){}
    public function after(){}

    public function indexAction(){
        $this->_data["projects"] = $projects =  Project::getAll();
        if($projects === false)
            $this->redirect("/");
        View::render();
    }

    public function showAction(){
        $id = @$this->FilterInt($this->route_params["id"]);
        $project = Project::getByPrimaryKey($id);

        if($project === false)
            $this->redirect("/projects");
        
        $this->_data["projectPhotos"] = ProjectPhoto::where("project = " . $id);
        $this->_data["project"] = $project;
        View::render();
    }


}