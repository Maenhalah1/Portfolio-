<?php 

namespace App\Models;

use Config\Config;
use Core\Model;

class Project extends Model{
    protected static $tableName = "projects";
    protected static $tableFields = [
        "project_name",
        "project_link",
        "project_video_link",
        "project_description",
        "client_name",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $project_name;
    public $project_link;
    public $project_video_link;
    public $project_description;
    public $client_name;

    public static function getAll(){
        $sql = "SELECT " . static::getTableName() . ".*, " . ProjectPhoto::getTableName() . ".photo_name as 'first_photo'" . " FROM " . static::getTableName();
        $sql .= " LEFT JOIN " . ProjectPhoto::getTableName();
        $sql .= " ON " . ProjectPhoto::getTableName() . ".project = " . static::getTableName() . ".id";
        $sql .= " GROUP BY " . ProjectPhoto::getTableName() . ".project";
        return static::queryToObjects($sql);
    }

    public function getRootPhotosPath(){
        return Config::UPLOADS_PATH . "projects_photos" . DS . $this->getPrimaryKey();
    }


}