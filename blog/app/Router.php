<?php
/**
 * User: leo
 * Date: 04/04/17
 * Time: 11:14
 */

namespace app;

use src\Controller;

/**
 * Class Router
 * @package app
 */
class Router
{
    private $uri;
    private $controller;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        // route the request internally
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // load controller
        $this->controller = new Controller();
    }

    /**
     * Router
     */
    public function routerRequete(){
        //If homepage
        if ('/web/index.php' === $this->uri || '/web/' === $this->uri) {
            $this->controller->homePage();
        }
        //If article page
        elseif ('/web/index.php/article' === $this->uri && isset($_GET['id'])) {
            $this->controller->articlePage();
        //If admin page
        } elseif ('/web/index.php/admin' === $this->uri){
            $this->controller->adminPage();
        //If not => 404
        } else {
            $this->controller->errorPage();
        }
    }


}