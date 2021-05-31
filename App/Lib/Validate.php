<?php
namespace App\Lib;

use Exception;

class Validate{
    use \App\Lib\Filters;

    protected  $post;
    protected  $rules;
    protected  $errors = [];
    protected const MODELS_NAMESPACE = "App\Models\\";

    public function __construct($post, $rules){
        $this->post = $post;
        $this->rules = $rules;
    }

    public static $RegExp_Patterns =  [
        "number"                => "/^(?:\-?[0-9]+)(?:\.[0-9]+)?$/",
        "int"                   => "/^[0-9]+$/",
        "float"                 => "/^((?:[0-9])+\.(?:[0-9])+)$/",
        "English_Chars"         => "/^[A-Za-z ]+$/",
        "English_Chars_Num"     => "/^[A-Za-z\s0-9 ]+$/",
        "Arabic_Chars"          => "/^[\p{Arabic} ]+$/u",
        "Arabic_Char_Num"       => "/^[\p{Arabic}\s0-9]+$/u",
        "email"                 => "/^([\w0-9_\-\.]+)@([\w\-]+\.)+[\w]{2,6}$/",
        "date"                  => "/^([1|2][0-9][0-9][0-9])[\-\/](0?[1-9]|1[0-2])[\-\/](0?[1-9]|[1-2][0-9]|3[0-1])$/",
        "username"              => "/^(?=[A-Za-z])(?:[\w\-0-9])*$/",
        "password"              => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/",
        "phonenumber"           => "/^(?:07)(?:7|8|9)[0-9]{7}$/",
        "url"                   => "/^https?:\/\/(www\.)?([A-Za-z0-9_-]+)\.([A-Za-z0-9]{2,})(\/(.*))?$/i",
        "youtube_embed"         => "/^https:\/\/www\.youtube\.com\/embed\/.+$/"

    ];

    protected static $errors_messages = [
        "required" => "%s is required",
        "unique" => '%s is already exists',
        "exist" => '%s is doesn\'t exists',
        "number" => "%s must be number only",
        "int" => "%s must be integer number only",
        "float" => "%s must be floating number only",
        "enChars" => "%s must be contains english letters only",
        "enCharsNumber" => "%s must be contains english letters or numbers only",
        "arChars" => "%s must be contains arabic letters only",
        "arCharsNumber" => "%s must be contains arabic letters or numbers only",
        "names" => "%s must be contains english letters only or arabic letters only",
        "max" => '%1$s must be less than or equal %2$s',
        "min" => '%1$s must be greater than or equal %2$s',
        "maxLength" => 'The length of %1$s must be less than or equal %2$s letters',
        "minLength" => 'The length of %1$s must be greater than or equal %2$s letters',
        "match" => '%1$s dosen\'t matched with %2$s',
        "match_password" => '%s isn\'t correct',
        "username" => "%s must be begin a letter and contains letters or numbers or -",
        "email" => "%s is not valid",
        "date" => "%s is not valid",
        "password" => "%s must be contains at least one uppercase and lowercase letter and numbers",
        "phoneNumber" => "%s in not valid must be like this pattern : 07(7|8|9)1234567",
        "url" => "%s is not valid",
        "urlYoutubeEmbed" => "%s for youtube embed is not valid",
        "minDate" => "%s is not valid",
        "maxDate" => "%s is not valid",
    ];




    public  function isValidate(){
        foreach($this->post  as $colume => $value){
            if(empty($value) && !array_key_exists("required",$this->rules[$colume]))
                continue;
            if(array_key_exists($colume, $this->rules)){
                $this->Validation($colume, $value, $this->rules[$colume]);
            }
        }
        if(empty($this->errors)){
            return true; 
         }else{
             return false;
         }
    }
    protected function Validation($colume, $value, $rules){
        foreach($rules as $rule => $policy){
            $class=get_class();
            if(method_exists($class,$rule)){
                $vars = $policy;
                if($rule === "match" || $rule === "exists" || $rule === "match_password"){
                    $vars = isset($_POST[$policy]) ? $_POST[$policy] : "";
                }
            
                $valid = call_user_func_array([$this, $rule], [$colume, $value, $vars]);
                if(!$valid){
                    $this->errors[$colume] = $this->setError($colume, $rule, $policy);
                    return false;
                }
            }else{
                throw new Exception("not Found $rule method validate",500);
            }
        }
        return true;
    }

    protected  function setError($colume, $rule, $policy){
        if(isset(static::$errors_messages[$rule])){
            $colume = str_replace("_", " ", $colume);
            return sprintf(static::$errors_messages[$rule], $colume, $policy);
        }else{
            throw new Exception("not Found $rule in form errors message",500);
        }
    }

    public function getErrors(){
        return $this->errors;
    }

    public  function required($colume,$value,$policy){
        $value = trim($value);
        return !empty($value) || $value !== ""; 
    }

    public  function match($colume, $value, $policy){
         return $policy === $value;
    }

    public  function exists($colume, $value, $policy){
        if(is_array($policy) && !empty($policy)){
            return in_array($value, $policy);
        }
        return true;
   }

   public  function match_password($colume, $value, $policy){
        return password_verify($value, $policy);
    }

    public  function unique($colume, $value, $policy){
        $sql = $colume . " = :colume";
        $values = [":colume" => static::FilterString($value)];
        $table = '';
        if(is_array($policy)){
            $table = $policy["table"];
            $except = $this->post[$policy["except"]];
            $sql .= " AND " . $colume . " != :except";
            $values[":except"] = $except;
        }else{
            $table = $policy;
        }

        $class = static::MODELS_NAMESPACE . $table;
        return !$class::where($sql, $values);
    }

    public  function number($colume,$value,$policy){
        return (bool)preg_match(static::$RegExp_Patterns['number'], $value);
    }

    public  function int($colume,$value,$policy){
        return (bool)preg_match(static::$RegExp_Patterns['int'], $value);
    }

    public  function float($colume,$value,$policy){
        return (bool)preg_match(static::$RegExp_Patterns['float'], $value);
    }

    public  function enchars($colume,$value,$policy){
        $value = trim($value);
        return (bool)preg_match(static::$RegExp_Patterns['English_Chars'], $value);
    }

    public  function encharsnumber($colume,$value,$policy){
        $value = trim($value);
        return (bool)preg_match(static::$RegExp_Patterns['English_Chars_Num'], $value);
    }

    public  function arChars($colume,$value,$policy){
        $value = trim($value);
        return (bool)preg_match(static::$RegExp_Patterns['Arabic_Chars'], $value);
    }

    public  function arCharsNum($colume,$value,$policy){
        $value = trim($value);
        return (bool)preg_match(static::$RegExp_Patterns['Arabic_Char_Num'], $value);
    }

    public  function max($colume, $value, $policy){

        $value = trim($value);
        
        if(!is_numeric($policy))
            throw new \Exception("Max Policy Must Be Number Only",500);

        if(is_numeric($value)){
            return $value <= $policy;
        }else{
            throw new \Exception("Max Value Must Be integer Number Only",500);
        }
    }
 
    public  function min($colume, $value, $policy){

        $value = trim($value);
        if(!is_numeric($policy))
            throw new \Exception("Min Policy Must Be Number Only",500);

        if(is_numeric($value)){
            return $value >= $policy;
        }else{
            throw new \Exception("Min value Must Be Number Only",500);
        }
    }

    public  function maxLength($colume, $value, $policy){
        if(!is_int($policy)){
            throw new \Exception("Max length Policy Must Be integer Number Only",500);
        }
        return mb_strlen($value) <= $policy;
    }

    public  function minLength($colume, $value, $policy){
        if(!is_int($policy)){
            throw new \Exception("Min length Policy Must Be Number Only",500);
        }
        return mb_strlen($value) >= $policy;
    }
 

    public  function email($colume, $value, $policy){
        return (bool)preg_match(static::$RegExp_Patterns['email'], $value);
    }

    public  function date($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['date'], $value);
    }

    public  function username($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['username'], $value);
    }

    public  function password($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['password'], $value);
    }

    public  function phoneNumber($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['phonenumber'], $value);
    }

    public  function names($colume, $value, $policy){
        return (bool) self::enchars($colume, $value, $policy) ? true : (self::archars($colume, $value, $policy) ? true : false);
    }

    public  function url($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['url'], $value);
    }

    public  function urlYoutubeEmbed($colume, $value, $policy){
        return (bool) preg_match(static::$RegExp_Patterns['youtube_embed'], $value);
    }

    public function minDate($colume, $value, $policy){
        if($policy == "now")
            $min = time();
        else
            $min = @strtotime($this->post[$policy]);

        $time = strtotime($value);
        if($min === false)
            return false;

        return $time >= $min;
    }

    public function maxDate($colume, $value, $policy){
            if($policy == "now")
                $max = time();
            else{
                $max = @strtotime($this->post[$policy]);
            }
        $time = strtotime($value);
        if($max === false)
            return false;
        return $time <= $max;
    }
}

?>