<?php 

namespace App\Models;

use Core\Model;

class Visitors extends Model{
    protected static $tableName = "visitors";
    protected static $tableFields = [
        "ip_address",
        "country",
        "city",
        "lat",
        "lon",
        "browser",
        "os",
        "device_type",
        "device_info",
    ];
    protected static $primaryKey = "id";

    protected $id;
    public $ip_address;
    public $country;
    public $city;
    public $lat;
    public $lon;
    public $browser;
    public $os;
    public $device_type;
    public $device_info;


}