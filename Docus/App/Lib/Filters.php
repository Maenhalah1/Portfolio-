<?php 
    namespace App\Lib;

    trait Filters{

        public static function FilterString($value){
            return stripslashes(trim(filter_var(strip_tags(addslashes($value)), FILTER_SANITIZE_STRING)));
        } 
        public static function FilterInt($value){
            return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        }
        function FilterFloat($value){
            return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
    }
?>