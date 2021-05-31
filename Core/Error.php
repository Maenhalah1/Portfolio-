<?php

namespace Core;

use Config\Config;

class Error {


    public static function errorHandler($level, $message, $file, $line){
        if (error_reporting() != 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }   
    }

    public static function exceptionHandler($exception)
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            if($code !== 404){
                $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
                ini_set('error_log', $log);
                $message = "Uncaught exception: '" . get_class($exception) . "'";
                $message .= " with message '" . $exception->getMessage() . "'";
                $message .= "\nStack trace: " . $exception->getTraceAsString();
                $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();
                $message .= "\n The Client IP is " . $_SERVER["REMOTE_ADDR"];
                $message .= "\n\n\n";
    
                error_log($message);
            }
            View::render(Config::VIEWS_PATH . DS . $code . ".view.php");
      
        }
    }

}