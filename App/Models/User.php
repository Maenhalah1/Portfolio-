<?php 

namespace App\Models;

use Core\Model;

class User extends Model{
    protected static $tableName = "users";
    protected static $tableFields = [
        "username",
        "email",
        "email_backup",
        "password",
        "first_name",
        "last_name",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $username;
    public $email;
    public $email_backup;
    public $password;
    public $first_name;
    public $last_name;

}