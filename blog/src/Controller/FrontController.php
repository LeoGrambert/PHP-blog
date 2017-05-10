<?php
/**
 * User: leo
 * Date: 04/04/17
 * Time: 11:28
 */

namespace src\Controller;

use app\App;
use src\Model\Article;
use src\Model\AuthDb;
use src\Model\Comment;
use src\Model\FlashMsg;
use src\Model\User;


/**
 * This is the controller for front pages
 * Class Controller
 * @package src
 */
class FrontController
{
    private $twig;
    private $articleClass;
    private $commentClass;
    private $userClass;
    private $appClass;
    private $authClass;
    private $flash;

    /**
     * Controller constructor.
     */
    public function __construct(){
        //load twig
        $this->twig = App::twig();
        //load class
        $this->articleClass = new Article();
        $this->commentClass = new Comment();
        $this->userClass = new User();
        $this->appClass = new App();
        $this->authClass = new AuthDb(App::getDatabase());
        //FlashMsg
        $this->flash = new FlashMsg();
    }

    /**
     * What do we do if we are on home page
     */
    public function homePage(){
        if ($this->authClass->logged()){
            $navAdmin = '<div id="navAdmin"><a href="/web/index.php/admin/articles/add/">Ajouter un article</a><a href="/web/index.php/admin/articles?p=1">Articles</a><a href="/web/index.php/admin/comments?p=1">Signalements</a><a href="/web/index.php/admin/pictures">Multimédia</a><a href="/web/index.php/admin/account/">Mon compte</a></div>';
        } else {
            $navAdmin = "";
        }
        //How many articles are there in BDD ?
        $articles = $this->articleClass->getArticles();
        $nbArt = count($articles);
        //How many pages are we displaying ?
        $nbPages = ceil($nbArt/5);
        $curPage = $_GET['p'];

        $articlesWhithPagination = $this->articleClass->getArticlesFront();
        echo $this->twig->render('home.html.twig', [
            'articlesWithPagination'=>$articlesWhithPagination,
            'articles'=>$articles,
            'navAdmin'=>$navAdmin,
            'nbPages'=>$nbPages,
            'curPage'=>$curPage
        ]);
    }

    /**
     * What do we do if we are on article page
     */
    public function articlePage(){
        //We first check valid id
        $existingIds = $this->articleClass->getArticlesIdInArray();
        if ($_GET['id'] > 0 && in_array($_GET['id'], $existingIds)){

            //If user is logged, we displaying an admin navbar
            if ($this->authClass->logged()){
                $navAdmin = '<div id="navAdmin"><a href="/web/index.php/admin/articles/add/">Ajouter un article</a><a href="/web/index.php/admin/articles?p=1">Articles</a><a href="/web/index.php/admin/comments?p=1">Signalements</a><a href="/web/index.php/admin/pictures">Multimédia</a><a href="/web/index.php/admin/account/">Mon compte</a></div>';
                $adminIsLogged = true;
            } else {
                $navAdmin = "";
                $adminIsLogged = false;
            }

            //query to get article by id
            $article = $this->articleClass->getArticleById();

            //query to get all articles
            $articles = $this->articleClass->getArticles();

            //query to add a comment
            if(isset($_POST['content'])){
                if(!empty($_POST['content']))
                {
                    $this->commentClass->addComment();
                    $this->flash->setFlash('Votre commentaire a été publié.', 'green lighten-2');
                    $this->flash->getFlash();
                } else {
                    $this->flash->setFlash('Une erreur est survenue. Votre commentaire n\'a pas été publié', 'red lighten-2');
                    $this->flash->getFlash();
                }
            }

            //query to get all comments by article id
            $comments = $this->commentClass->getComments();

            //Get comments replies
            $comments_by_id = [];
            foreach($comments as $comment){
                $comments_by_id[$comment->getId()] = $comment;
            }
            foreach ($comments as $k => $comment){
                //If comment has children, we add them in an array, and we call this array in twig view with a margin-left
                if ($comment->getParentCommentId() != 0){
                    $comments_by_id[$comment->getParentCommentId()]->children[] = $comment;
                    unset($comments[$k]);
                }
            }

            //Report a comment
            //We check if 'report' session exists. If not, we create it (an empty array)
            if(!isset($_SESSION['report'])){
                $_SESSION['report'] = [];
            }
            if (isset($_POST['comment-id']) && !empty($_POST['comment-id'])){
                //If comment id is in array ($_SESSION['report']), we displaying an error message
                if(in_array($_POST['comment-id'], $_SESSION['report'])){
                    $this->flash->setFlash('Vous avez déjà signalé ce commentaire.', 'red lighten-2');
                    $this->flash->getFlash();
                }
                //If comment id isn't in array, we report it and we displaying a success message
                else {
                    $this->commentClass->reportComment();
                    $this->flash->setFlash('Le signalement a bien été envoyé à l\'administrateur', 'green lighten-2');
                    $this->flash->getFlash();
                }
            }

            //Generate newer article.
            //In the returned array (by getNextArticle), we get id and we send it in view.
            if($this->articleClass->getNextArticle() != []){
                $nextArticle = $this->articleClass->getNextArticle()[0];
                $nextId = $nextArticle->getId();
            } else {
                $nextId = null;
            }

            //Generate older article.
            //In the returned array (by getPreviousArticle), we get the article preceding the current article.
            //We save this article in $previousId. And we send it in view.
            if ($_GET['id'] > 1){
                $previousArticles = $this->articleClass->getPreviousArticle();
                $previousId = $previousArticles[count($previousArticles)-1];
            } else {
                $previousId = null;
            }

            echo $this->twig->render('article.html.twig', [
                'article'=>$article,
                'articles'=>$articles,
                'comments'=>$comments,
                'nextId'=>$nextId,
                'previousId'=>$previousId,
                'navAdmin'=>$navAdmin,
                'adminIsLogged'=>$adminIsLogged
            ]);

        } else {
            //If id isn't valid
            echo $this->twig->render('error404.html.twig');
        }
    }

    /**
     * What do we do if we are on login page
     */
    public function loginPage(){
        //If user is log -> he's redirected to admin
        if($this->authClass->logged()){
            header('Location: /web/index.php/admin/home/');
        } else {
            //If he's not log, he need to log in
            if(!empty($_POST)){
                if($this->authClass->login(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password'])) === true){
                    header('Location: /web/index.php/admin/home/');
                } else {
                    $this->flash->setFlash('Les identifiants sont incorrects', 'red lighten-2');
                    $this->flash->getFlash();
                }
            }
            echo $this->twig->render('login.html.twig');
        }
    }

    /**
     * What do we do if we are on error page
     */
    public function errorPage()
    {
        header('HTTP/1.1 404 Not Found');
        echo $this->twig->render('error404.html.twig');
    }

}