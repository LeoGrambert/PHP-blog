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
    public function routerRequete()
    {
        //If admin page (disconnect)
        if ('/web/index.php' === $this->uri || '/web/' === $this->uri) {
            if(isset($_GET['p']) && $_GET['p'] === 'deconnexion'){
                $this->controller->adminDisconnectPage();
            } else {
        //If homepage
                $this->controller->homePage();
        //If article page
            }
        } elseif ('/web/index.php/article' === $this->uri && isset($_GET['id'])) {
            $this->controller->articlePage();
         //If login page
        } elseif ('/web/index.php/login/' === $this->uri) {
            $this->controller->loginPage();
        //If admin page (dashboard)
        } elseif ('/web/index.php/admin/home/' === $this->uri) {
            $this->controller->adminHomePage();
        //If admin page (update an article)
        } elseif (('/web/index.php/admin/articles' === $this->uri) && ($_GET['p'] === 'edit') && (isset($_GET['id']))){
            $this->controller->adminEditArticlePage();
        //If admin page (add an article)
        } elseif ('/web/index.php/admin/articles/add/' === $this->uri) {
            $this->controller->adminAddArticlePage();
        //If admin page (delete an article)
        } elseif (('/web/index.php/admin/articles' === $this->uri) && ($_GET['p'] === 'delete') && (isset($_GET['id']))){
            $this->controller->adminDeleteArticlePage();
        //If admin page (articles)
        } elseif (('/web/index.php/admin/articles' === $this->uri)) {
            $this->controller->adminArticlesPage();
        //If admin page (delete a comment)
        } elseif (('/web/index.php/admin/comments' === $this->uri) && ($_GET['p'] === 'delete') && (isset($_GET['id']))){
            $this->controller->adminDeleteCommentPage();
        //If admin page (comments)
        } elseif ('/web/index.php/admin/comments' === $this->uri) {
            $this->controller->adminCommentsPage();
        //If admin page (pictures)
        } elseif ('/web/index.php/admin/pictures/' === $this->uri) {
            $this->controller->adminPicturesPage();
        //If admin page (my account)
        } elseif ('/web/index.php/admin/account/' === $this->uri) {
            $this->controller->adminAccountPage();
        //If not => 404
        } else {
            $this->controller->errorPage();
        }
    }


}