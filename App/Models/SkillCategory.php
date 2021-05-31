<?php 

namespace App\Models;

use Core\Model;

class SkillCategory extends Model{
    protected static $tableName = "skills_categories";
    protected static $tableFields = [
        "name",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $name;

}