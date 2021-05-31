<?php 

namespace App\Models;

use Core\Model;

class Education extends Model{
    protected static $tableName = "educations";
    protected static $tableFields = [
        "degree",
        "university",
        "major",
        "college",
        "degree_abbreviation",
        "start_date",
        "end_date",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $degree;
    public $university;
    public $major;
    public $college;
    public $degree_abbreviation;
    public $start_date;
    public $end_date;

}