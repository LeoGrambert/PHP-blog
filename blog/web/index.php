<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

use app\App;
use app\Router;


/*
 * Load what we need
 *
 */
//call load app function -> initialize session and load autoloader
if(file_exists('../app/App.php')){
    require '../app/App.php';
    App::load();
} else {
    require '../app/App_test.php';
    \app\App_test::load();
}


/*
 * Router
 *
 */
require '../app/Router.php';
$router = new Router();
$router->routerRequete();
