<?php 
namespace App\Controllers;


use Core\Controller;
use Core\View;

class Services extends Controller{

    public function before(){}
    public function after(){}

    public function indexAction(){
        View::render();
    }

}