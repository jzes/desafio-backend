<?php
namespace App\Router;

use App\Controllers\OrderBy;

class Router {
    public $app;
    function __construct($app){
        $this->app = $app;
    }

    function defineRoutes(){


        $app->run();
    }
    

}