<?php 
namespace App\Lib;

trait Helper{
    public static function inputValue($name ,$object = null){
        return isset($_POST[$name]) ? $_POST[$name] : (($object !== null && isset($object->$name) && !empty($object->$name)) ? $object->$name : "");
    }

    public static function selected($name, $Eq, $object = null){
        return isset($_POST[$name]) && ($_POST[$name] == $Eq) ? "selected" : 
        (( is_object($object) && property_exists($object, $name) && $object->$name == $Eq) ? "selected" : "");
    }

    public static function getFormErrors($error_name,$errors){
        if(isset($errors) && is_array($errors) && !empty($errors) && isset($errors[$error_name])){
            return "<div class='error-field-form'>" .  $errors[$error_name] . "</div>";
        }else{
            return null;
        }
    }

    public static function getFilesErrors($errfiles,$index = null){
        $result ="";
        if(!empty($index)){
            $errfiles = @$errfiles[$index];
        }
        if(isset($errfiles) && is_array($errfiles)){
            foreach($errfiles as $error){
                if(is_array($error)){
                    foreach($error as $val){
                            $result     .= "<div class='error-field-form'>";
                            $result     .= $val;
                            $result     .= "</div>";
                        }
                }else{
                     $result     .= "<div class='error-field-form'>";
                     $result     .= $error;
                     $result     .= "</div>";
                }
            }
        }
        return $result;
    }
  
    public static function redirect($path){
        header("Location:" . $path);die();
    }
    
    public static function Refresh(){
        $path = "/" . (!empty($_SERVER["QUERY_STRING"]) ?  $_SERVER["QUERY_STRING"] : "");
        header("Location:" . $path);die();
    }
}

?>