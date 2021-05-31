<?php 

namespace App\Models;

use Core\Model;

class Skill extends Model{
    protected static $tableName = "skills";
    protected static $tableFields = [
        "name",
        "skill_category",
        "ratio",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $name;
    public $skill_category;
    public $ratio;

    public static function getAll(){
        $sql = "SELECT " . static::getTableName() . ".*, " . SkillCategory::getTableName() . ".name as 'category_name'" . " FROM " . static::getTableName();
        $sql .= " INNER JOIN " . SkillCategory::getTableName();
        $sql .= " ON " . SkillCategory::getTableName() . ".id = " . static::getTableName() . ".skill_category";
        $sql .= " ORDER BY " . static::getTableName() . ".skill_category , " . static::getTableName() . ".id " . "ASC";
        return static::queryToObjects($sql);
    }

}