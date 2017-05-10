<?php
/**
 * User: leo
 * Date: 04/04/17
 * Time: 11:14
 */

namespace app;

use src\Controller\AdminController;
use src\Controller\FrontController;

/**
 * Class Router
 * @package app
 */
class Router
{
    private $uri;
    private $frontController;
    private $adminController;

    /**
     * Router constructor.
     * We get the url and we load controllers.
     */
    public function __construct()
    {
        // route the request internally
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // load controller
        $this->frontController = new FrontController();
        $this->adminController = new AdminController();
    }

    /**
     * This is the router.
     */
    public function routerRequete()
    {
        //If admin page (disconnect)
        if ('/front/projets/blogEcrivain/blog/web/index.php' === $this->uri) {
            if(isset($_GET['p']) && $_GET['p'] === 'deconnexion'){
                $this->adminController->adminDisconnectPage();

        //If homepage
            } elseif(isset($_GET['p'])) {
                $this->frontController->homePage();
            }

        //If article page
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/article' === $this->uri && isset($_GET['id'])) {
            $this->frontController->articlePage();

         //If login page
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/login/' === $this->uri) {
            $this->frontController->loginPage();

        //If admin page (dashboard)
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/admin/home/' === $this->uri) {
            $this->adminController->adminHomePage();

        //If admin page (update an article)
        } elseif (('/front/projets/blogEcrivain/blog/web/index.php/admin/articles' === $this->uri) && ($_GET['p'] === 'edit') && (isset($_GET['id']))){
            $this->adminController->adminEditArticlePage();

        //If admin page (add an article)
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/admin/articles/add/' === $this->uri) {
            $this->adminController->adminAddArticlePage();

        //If admin page (delete an article)
        } elseif (('/front/projets/blogEcrivain/blog/web/index.php/admin/articles' === $this->uri) && ($_GET['p'] === 'delete') && (isset($_GET['id']))){
            $this->adminController->adminDeleteArticlePage();

        //If admin page (articles)
        } elseif (('/front/projets/blogEcrivain/blog/web/index.php/admin/articles' === $this->uri)) {
            $this->adminController->adminArticlesPage();

        //If admin page (delete a comment)
        } elseif (('/front/projets/blogEcrivain/blog/web/index.php/admin/comments' === $this->uri) && ($_GET['p'] === 'delete') && (isset($_GET['id']))){
            $this->adminController->adminDeleteCommentPage();

        //If admin page (comments)
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/admin/comments' === $this->uri) {
            $this->adminController->adminCommentsPage();

        //If admin page (pictures)
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/admin/pictures' === $this->uri) {
            $this->adminController->adminPicturesPage();

        //If admin page (my account)
        } elseif ('/front/projets/blogEcrivain/blog/web/index.php/admin/account/' === $this->uri) {
            $this->adminController->adminAccountPage();

        //If not => 404
        } else {
            $this->frontController->errorPage();
        }
    }


}