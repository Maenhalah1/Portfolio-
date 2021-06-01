<?php 
namespace App\Controllers;

use App\Lib\ApiCall;
use App\Lib\Files;
use App\Lib\Services ;
use App\Models\Education;
use App\Models\Settings;
use App\Models\Skill;
use App\Models\Users;
use Config\Config;
use Core\Controller;
use Core\View;

class Home extends Controller{

    public function before(){
        $this->saveVisitorsInformation();
    }
    public function after(){}

    public function indexAction(){
        
        $this->_data["settings"] = $settings = Settings::getByPrimaryKey(1);
        if($settings !== false){
            $settings->main_video = pathinfo($settings->main_video);
        }
        $skills = Skill::getAll();
        if($skills !== false){
            $skillsGroups = [];
            $counter = 0;
            $skillsCount = count($skills) - 1;
            for($i = 0; $i <= $skillsCount; $i++){
                $skillsGroups[$counter][] = $skills[$i];
                if( $i < $skillsCount && $skills[$i]->skill_category != $skills[$i+1]->skill_category)
                    $counter++;
            }
            $this->_data["skillsGroups"] = $skillsGroups;
            unset($skillsGroups,$counter);
        }
        $educations = Education::getAll();
        if($educations !== false){
            foreach($educations as $education){
                $startTime = strtotime($education->start_date);
                $endTime = strtotime($education->end_date);
                $education->start_year = date("Y",$startTime);
                $education->end_year = $endTime <= time() ? date("Y",$endTime) : "Present";
                $education->start_date = date("M Y", $startTime);
                $education->end_date = $endTime <= time() ? date("M Y",$endTime) : "Present";
            }
        }

        $this->_data["educations"] = $educations;
        View::render();
    }

    public function testAction(){
        // $loc = (ApiCall::getClientIPInfo("91.186.250.71"));
        // $this->_data["lat"] = $loc["lat"];
        // $this->_data["lon"] = $loc["lon"];
        // $this->_data["ip"] = Services::getUserIPAddress();
        


        View::render();
    } 

}