<?php

/**
 * Front controller
 */

use App\Mailer;
use Config\Config;
use Core\Router;
use Core\SessionManager;
ob_start();
error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
require(".." . DS . "App" . DS . "Autoload.php");
require '../vendor/autoload.php';

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Router();
// Add Routes
$router->add("",["controller" => "home", "action" => "index"]);
$router->add("admin", ["controller" => "home", "action" => "index", "namespace"=>"Admin"]);
$router->add("{controller}",["action" => "index"]);
$router->add("admin/{controller}", ["action" => "index","namespace"=>"Admin"]);
$router->add("admin/{controller}/{action}", ["namespace"=>"Admin"]);
$router->add("admin/{controller}/{id:\d+}/{action}", ["namespace"=>"Admin"]);
// $router->add("{controller}/{id:\d+}",["action" => "view"]);
$router->add("{controller}/{action}");
$router->add("{controller}/{id:\d+}/{action}");
$router->dispatch($_SERVER['QUERY_STRING']);

session_write_close();
ob_flush();


