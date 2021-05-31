<?php 

namespace App\Controllers\Admin;

use APP\Lib\Files;
use App\Lib\Messenger;
use App\Lib\Validate;
use App\Models\Settings as M_Settings;
use Config\Config;
use Core\Controller;
use Core\View;

class Settings extends Controller{

    use \App\Lib\Helper;
    use \App\Lib\Filters;

    private static $rules = [
        "about_me_text" => ["required" => true, "minLength" => 5, "maxLength" => 500],
        "resume_text" => ["required" => true, "minLength" => 5, "maxLength" => 250],
        "footer_text" => ["required" => true, "minLength" => 5, "maxLength" => 500],
    ];

    public function before(){
        if(!$this->auth->isLogin())
            $this->redirect("/admin/auth");
    }
    public function after(){}

    public function indexAction(){
        $this->_data["form_errors"] = '';
        $this->_data["files_errors"] = '';
        $this->_data["settings"] = $settings = M_Settings::getByPrimaryKey(1);

        if(isset($_POST["save"])){
            $_POST["about_me_text"] = static::FilterString($_POST['about_me_text']);
            $_POST["resume_text"] = static::FilterString($_POST['resume_text']);
            $_POST["footer_text"] = static::FilterString($_POST['footer_text']);
            $canBeNullFile = false;            
            if($settings !== false){
                $canBeNullFile = true;
            }
            $validate = new Validate($_POST, static::$rules);
            $mainVideo = new Files($_FILES["main_video"], $canBeNullFile, 4, 1);
            $aboutMePhoto = new Files($_FILES["about_me_photo"], $canBeNullFile, 1, 1);
            $resumeFile = new Files($_FILES["resume_file"], $canBeNullFile, 3, 1);
            $feildsValid = $validate->isValidate();
            $validMainVideo = $aboutMePhoto->filesValidation();
            $validAboutMePhoto = $mainVideo->filesValidation();
            $validResumeFile = $resumeFile->filesValidation();

            if($feildsValid && $validMainVideo && $validAboutMePhoto && $validResumeFile){
                if($settings === false)
                    $settings = new M_Settings();
                if($settings !== false){
                    if($mainVideo->getNumberFilesUpload() > 0)
                        $oldVideo = $settings->main_video;
                    if($aboutMePhoto->getNumberFilesUpload() > 0)
                        $oldAboutMe = $settings->about_me_photo;
                    if($resumeFile->getNumberFilesUpload() > 0)
                        $oldResumeFile = $settings->resume_file;
                }
                $settings->about_me_text = $_POST['about_me_text'];
                $settings->resume_text = $_POST['resume_text'];
                $settings->footer_text = $_POST['footer_text'];
                if($mainVideo->getNumberFilesUpload() > 0)
                    $settings->main_video = $mainVideo->getFileNewName();
                if($aboutMePhoto->getNumberFilesUpload() > 0)
                    $settings->about_me_photo = $aboutMePhoto->getFileNewName();
                if($resumeFile->getNumberFilesUpload() > 0)
                    $settings->resume_file = $resumeFile->getFileNewName();
                if($settings->save()){
                    $mainVideo->upload(Config::MEDIA_UPLOAD_PATH);
                    $aboutMePhoto->upload(Config::MEDIA_UPLOAD_PATH);
                    $resumeFile->upload(Config::MEDIA_UPLOAD_PATH);
                    if($settings !== false){
                        if(isset($oldVideo))
                            Files::deleteDirectory(Config::MEDIA_UPLOAD_PATH . DS . $oldVideo);
                        if(isset($oldAboutMe))
                            Files::deleteDirectory(Config::MEDIA_UPLOAD_PATH . DS . $oldAboutMe);
                        if(isset($oldResumeFile))
                            Files::deleteDirectory(Config::MEDIA_UPLOAD_PATH . DS . $oldResumeFile);
                    }
                    $this->messages->addMassege("action_settings","The Settings is Saved successfully");
                    static::Refresh();
                }else{
                    $this->messages->addMassege("action_settings","The Settings isn't Saved successfully",Messenger::WARNING_MASSEGE);
                    static::Refresh();
                }


                // $education = new M_Education();
                // $education->degree = $_POST["degree"];
                // $education->university = $_POST["university"];
                // $education->major = $_POST["major"];
                // $education->college = $_POST["college"];
                // $education->degree_abbreviation = $_POST["degree_abbreviation"];
                // $education->start_date = $_POST["start_date"];
                // $education->end_date = $_POST["end_date"];

              
            }else{
                $this->_data["form_errors"] = $validate->getErrors();
                $files_errors["main_video"] = $mainVideo->getFilesErrors();
                $files_errors["about_me_photo"] = $aboutMePhoto->getFilesErrors();
                $files_errors["resume_file"] = $resumeFile->getFilesErrors();
                $this->_data["files_errors"] = $files_errors;
            }
        }
        $message = $this->messages->getMassege("action_settings");
        if($message !== false)
            $this->_data["user_message"] = $message;
        View::render();
    }

}