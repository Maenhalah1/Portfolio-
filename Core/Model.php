<?php 

namespace Core;

use App\Lib\Database;
use Exception;

abstract class Model{
    const FILTER_STRING_DATA = 1;
    const FILTER_BOOL_DATA = 2;
    const FILTER_INTEGER_DATA = 3;
    const FILTER_FLOAT_DATA = 4;

    protected static $db = null;
    protected static $tableName = null;
    protected static $tableFields = [];
    protected static $primaryKey;


    function __construct(){
        static::checkDb();
    }

    protected static function checkDb(){
        if(!is_object(static::$db)){
            throw new Exception("You Must Determine Database Object in Model Class", 500);
        }
    }

    public static function getTableName(){
        return static::$tableName;
    }

    public  function getPrimaryKey(){
        return $this->{static::$primaryKey};
    }

    protected function setPrimaryKey($pk){
        $this->{static::$primaryKey} = $pk;
    }

    public static function setDB(Database $db){
        static::$db = $db;
    }

    public static function queryToObjects($sql ,$values = NULL) {
        $stmt = static::$db->query($sql ,$values);
        $class = get_called_class();
        $rows = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        if(!empty($rows) && isset($rows[0]) && !empty($rows[0])){
           return $rows;
        }else{
            return false;
        }
    }

    public static function getByPrimaryKey($pk){
        $sql = "SELECT * FROM " . static::getTableName();
        $sql .= " WHERE " . static::$primaryKey . " = :pk";
        $values = [":pk" => $pk];
        $result = static::queryToObjects($sql, $values);
        return $result !== false ? $result[0] : false;
    }

    public static function getAll(){
        $sql = "SELECT * FROM " . static::getTableName();
        return static::queryToObjects($sql);
    }

    public static function where($where, $values = NULL){
        $sql = "SELECT * FROM " . static::getTableName() . " WHERE " . $where;
        return static::queryToObjects($sql, $values);
    }

    protected function prepareActions(array $fields, array &$values){
        $result = '';
        if(!empty($fields)){
            foreach($fields as $field){
                $value = ":" . $field;
                $result .=  $field . " = " . $value . ", ";
                $values[$value] = $this->{$field};
            }
            
            return trim($result,", ");
        }else   
            return false;
    }

    public function create(){
        $values = [];
        $sql = "INSERT INTO " . static::$tableName . " SET " . $this->prepareActions(static::$tableFields, $values);
        $stmt = static::$db->query($sql,$values);
        if($stmt){
            $this->setPrimaryKey(static::$db->lastID());
            return true;
        }else{
            return false;
        }       
    }

    public function update(){
        $values = [];
        $sql = "UPDATE " . static::$tableName . " SET " . $this->prepareActions(static::$tableFields, $values);
        $sql .= " WHERE " . static::$primaryKey . " = " . $this->getPrimaryKey();
        $stmt = static::$db->query($sql, $values);    
        return $stmt->rowCount() > 0 ? true : false;        
    }

    public function save(){
        if($this->getPrimaryKey() !== null && $this->getPrimaryKey() > 0){
            return $this->update();
        }else{
            return $this->create();
        }
    }

    public function delete(){
        $sql = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = " . $this->getPrimaryKey();
        $stmt = static::$db->query($sql);    
        return $stmt->rowCount() > 0 ? true : false;          
    }
    

    public static function deleteWithWhere($where,$values){
        global $database;
        $sql = "DELETE FROM " . static::$tableName . " WHERE " . $where;
        $stmt = static::$db->query($sql, $values);
        return ($stmt->rowCount()) ? true : false;
    }


}