<?php 

namespace App\Lib;

use Exception;

Class Database{

    private $host;
    private $db_name;
    private $user;
    private $password;
    private $connection = null;

    private $lastID;

    function __construct($host, $db_name, $user, $password){
        $this->host = $host;
        $this->db_name = $db_name;
        $this->user = $user;
        $this->password = $password;
        $this->connection();
    }

    private function connection(){
        try{
			$this->connection = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name , $this->user, $this->password);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
		}catch(\PDOException $e) {
            throw new Exception($e->getMessage(), 500);
		}
    }

    public function query($sql, $values = null){
        $commit = true;
        try{
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($values);
            $commit = $this->checkQuery($stmt) ? true : false;

        }catch(\PDOException $e){
            $commit = false; 
            $this->connection->rollBack();
            throw new Exception($e->getMessage(), 500);
        }
        if($commit){
            $this->lastID = $this->connection->lastInsertId();
            $this->connection->commit();
            return $stmt;
        }else{
            throw new Exception("Query Field", 500);
        }
    }

    public function checkQuery($stmt){
        if($stmt){
            return true;
        }else{
            $this->connection->rollBack();
            return false;
        }
    }

    public function lastID() {
        return $this->lastID;
    }


}