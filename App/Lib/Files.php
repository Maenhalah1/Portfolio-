<?php 
namespace App\Lib;

use Config\Config;
use Exception;

class Files{
    
    protected $name;
    protected $newName;
    protected $Tmpname;
    protected $type;
    protected $extentions;
    protected $size;
    protected $maxSize;
    protected $error;

    protected $filesType = 1; // 1: images , 2: documents , 3: image+documents, 4: video
    protected $filesIsValid = false;
    protected $CanBeNull;
    protected $maxNumberFiles;
    protected $filesValidationErrors = [];

    protected $numberFiles;

    // private static $_language;

    private static $maxFilesSize = Config::MAX_FILES_SIZE;
    private static $maxImagesSize = Config::MAX_IMAGES_SIZE;
    private static $maxVideoSize = Config::MAX_VIDEOS_SIZE;

    private static $ImagesExtensionsValid = [
        "jpg", "png", "jpeg", "gif", "jfif", "svg"
    ];
    private static $DocusExtensionsValid = [
        "doc", "docx", "pdf", "ppt", "pptx"
    ];
    private static $VideosExtensionsValid = [
        "mp4", "ogv", "webm"
    ];


    private $errors_messages = [
        "must_upload" => "You must be upload file",
        "upload_exceeded" => "You have exceeded upload limit",
        "size_large" => "the file named (%s) has exceeded max size (the max size is : %d)",
        "extension_not_valid" => 'the file named (%1$s) his extension is not valid ,must be one of these extensions (%2$s)',

    ];




    public function __construct(array $file, bool $canBeNull = false, int $filesType = 1, $maxNumberFiles = 1)
    {
        if($filesType > 4 || $filesType < 1)
            throw new Exception("The number is refering to type of files is not Valid", 500);
  
        if(is_array($file['name'])) $this->name = $file['name']; else $this->name[] = $file['name'];
        if(is_array($file['size'])) $this->size = $file['size']; else $this->size[] = $file['size'];
        if(is_array($file['type'])) $this->type = $file['type']; else $this->type[] = $file['type'];
        if(is_array($file['error'])) $this->error = $file['error']; else $this->error[] = $file['error'];
        if(is_array($file['tmp_name'])) $this->Tmpname = $file['tmp_name']; else $this->Tmpname[] = $file['tmp_name'];

        $this->filesType    = $filesType;
        $this->CanBeNull    = $canBeNull;
        $this->numberFiles = !empty($this->name) && $this->error[0] !== 4 ? count($this->name) : 0;
        $this->maxNumberFiles = $maxNumberFiles;
        $this->prepareFile();
    }

    // public static function setLanguage($lang){
    //     self::$_language = $lang;
    // }

    protected function checkValidSize($size , $max){
        return (bool)$size <= $max;
    }

    protected function checkValidExtension($ext, array $extentions){
        return (bool)in_array($ext, $extentions);
    }


    protected function createNewFileName($ext){
        return rand(0,1000000000000) . rand(0,1000000000000) . "." . $ext;
    } 

    protected function prepareFile(){
        for($i=0; $i<$this->numberFiles;$i++){ 
            $ext = explode(".", $this->name[$i]); // convert the name to array
            $ext = strtolower(end($ext)); // get the type
            $this->extentions[$i] = $ext;
            $this->maxSize[$i] = $this->getMaxSize($this->extentions[$i]);
            $this->newName[$i] = $this->createNewFileName($this->extentions[$i]);

        }
    }

    protected function getError($error_type,array $data = []){
        array_unshift($data,$this->errors_messages[$error_type]);
        return call_user_func_array("sprintf", $data);
        //return self::$_language->feedKey("text_error_file_" . $error_type, $data);
    }

    protected function getExtentions($filesType , &$extentions = null){
        if($filesType == 1){
            $extentions = self::$ImagesExtensionsValid;
        }else if($filesType == 2){
            $extentions = self::$DocusExtensionsValid;
        }else if ($filesType == 3){
            $extentions = array_merge(self::$ImagesExtensionsValid, self::$DocusExtensionsValid);
        }else if($filesType == 4){
            $extentions = self::$VideosExtensionsValid;
        }else{
            throw new Exception("The number is refering to type of files is not Valid", 500);
        }
        return implode(" , ", $extentions);
    }

    protected function getMaxSize($extention){
        $max = null;
        if($this->filesType == 1){
            $max = self::$maxImagesSize;
        }else if ($this->filesType == 2){
            $max = self::$maxFilesSize;
        }else if ($this->filesType == 3){
            if(in_array($extention, self::$ImagesExtensionsValid)){
                $max = self::$maxImagesSize;         
            }else if(in_array($extention, self::$DocusExtensionsValid)){
                $max = self::$maxFilesSize;         
            }
        }else if ($this->filesType == 4){
            $max = self::$maxVideoSize;
        }else{
            throw new Exception("The number is refering to type of files is not Valid", 500);
        }
        return $max;
    }

    public static function getAllowdDocusExtensions(){
        return implode(" , ", self::$DocusExtensionsValid);
    }

    public static function getAllowdImagesExtensions(){
        return implode(" , ", self::$ImagesExtensionsValid);
    }

    public function getNumberFilesUpload(){
        return $this->numberFiles;
    }

    public function getFilesErrors(){
        return $this->filesValidationErrors;
    }

    public function getFileNewName($id = 0){
        return $this->newName[$id];
    }

    public function filesValidation(){
        
        $file_errors = [];
        var_dump($this->numberFiles);

        if($this->error[0] == 4 && !$this->CanBeNull){
            $file_errors[0]["fileerror"] = $this->getError("must_upload");
        }
        
        if($this->numberFiles > $this->maxNumberFiles){
            $file_errors[0]["fileerror"] = $this->getError("upload_exceeded");
        }
        $extentions = null;
        $extentionsAsString = $this->getExtentions($this->filesType, $extentions);

        for($i = 0; $i < $this->numberFiles; $i++){
            if(!$this->checkValidSize($this->size[$i],$this->maxSize[$i]))
                $file_errors[$i]["filesize"] = $this->getError("size_large",[$this->name[$i], $this->maxSize[$i] / 1024 / 1024]);

            if(!$this->checkValidExtension($this->extentions[$i], $extentions))
                $file_errors[$i]["fileextention"] = $this->getError("extension_not_valid",[$this->name[$i], $extentionsAsString]);
        }

        if(empty($file_errors)){
            $this->filesIsValid = true;
            return true;
        }else{
            $this->filesValidationErrors = $file_errors;
            return false;
        }
    }

    public function upload($path){
        if(!$this->filesIsValid){
            throw new Exception("The files is not ready to Upload", 500);
        }
        if(!is_dir($path)){
            throw new Exception("The Path Files is not Found", 500);
        }

        for($i = 0; $i < $this->numberFiles; $i++){
            move_uploaded_file($this->Tmpname[$i], $path . DS . $this->newName[$i]);
        }
    }


    // delete all photo or files  with delete his dircetory 
    public static function deleteDirectory($path){
        if(is_dir($path)){
            $files = glob($path . "*" , GLOB_MARK);
            foreach($files as $file){
                static::deleteDirectory($file);
            }
            if(is_dir($path))
                rmdir($path);
        }elseif(is_file($path)){
            unlink($path);
        }else{
            return false;
        }           
    }


    //Create Directory
    public static function createDirectory($path){
        if(!is_dir($path)){
            mkdir($path);
        }
    }
}