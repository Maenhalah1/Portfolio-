<?php 

namespace App\Models;

use Core\Model;

class Settings extends Model{
    protected static $tableName = "settings";
    protected static $tableFields = [
        "main_video",
        "about_me_photo",
        "about_me_text",
        "resume_text",
        "resume_file",
        "footer_text",
    ];
    protected static $primaryKey = "id";
    
    protected $id;
    public $main_video;
    public $about_me_photo;
    public $about_me_text;
    public $resume_text;
    public $resume_file;
    public $footer_text;

}