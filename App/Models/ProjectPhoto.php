<?php 

namespace App\Models;

use Core\Model;

class ProjectPhoto extends Model{
    protected static $tableName = "projects_photos";
    protected static $tableFields = [
        "photo_name",
        "project",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $photo_name;
    public $project;




}