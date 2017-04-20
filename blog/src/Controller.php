<?php
/**
 * User: leo
 * Date: 04/04/17
 * Time: 11:28
 */

namespace src;

use app\App;
use src\Model\Article;
use src\Model\AuthDb;
use src\Model\Comment;
use src\Model\FlashMsg;


/**
 * Class Controller
 * @package src
 */
class Controller
{
    private $twig;
    private $articleClass;
    private $commentClass;
    private $appClass;
    private $authClass;
    private $articles;
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
        $this->appClass = new App();
        $this->authClass = new AuthDb(App::getDatabase());
        //query to get all articles
        $this->articles = $this->articleClass->getArticles();
        //FlashMsg
        $this->flash = new FlashMsg();
    }

    /**
     * What we do if we are on home page
     */
    public function homePage(){
        if ($this->authClass->logged()){
            $navAdmin = '<div id="navAdmin"><a href="/web/index.php/admin/articles/add/">Ajouter un article</a><a href="/web/index.php/admin/articles?p=1">Articles</a><a href="/web/index.php/admin/comments/">Commentaires</a><a href="/web/index.php/admin/pictures/">Multimédia</a><a href="/web/index.php/admin/account/">Mon compte</a></div>';
        } else {
            $navAdmin = "";
        }
        echo $this->twig->render('home.html.twig', ['articles'=>$this->articles, 'navAdmin'=>$navAdmin]);
    }

    /**
     * What we do if we are on article page
     */
    public function articlePage(){
        if ($this->authClass->logged()){
            $navAdmin = '<div id="navAdmin"><a href="/web/index.php/admin/articles/add/">Ajouter un article</a><a href="/web/index.php/admin/articles?p=1">Articles</a><a href="/web/index.php/admin/comments/">Commentaires</a><a href="/web/index.php/admin/pictures/">Multimédia</a><a href="/web/index.php/admin/account/">Mon compte</a></div>';
        } else {
            $navAdmin = "";
        }

        //query to get article by id
        $article = $this->articleClass->getArticleById();

        //query to add a comment
        if(isset($_POST['content'])){
            if(!empty($_POST['content']))
            {
                $this->commentClass->addComment();
            } else {

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
        if (isset($_POST['comment-id']) && !empty($_POST['comment-id'])){
            $this->flash->setFlash('Le signalement a bien été envoyé à l\'administrateur', 'green lighten-2');
            $this->commentClass->reportComment();
        }

        //Generate newer article.
        //In the returned array (by getNextArticle), we get id and we send it in view.
        if($this->articleClass->getNextArticle() != []){
            $nextArticles = $this->articleClass->getNextArticle();
            foreach ($nextArticles as $nextArticle){
                $nextId = $nextArticle;
            }
        } else {
            $nextId = null;
        }

        //Generate older article.
        //In the returned array (by getPreviousArticle), we get the article preceding the current article.
        //We save this article in $previousId. And we send it in view.
        if ($_GET['id'] > 1){
            $previousArticles = $this->articleClass->getPreviousArticle();
            $previousId = $previousArticles[count($previousArticles)-2];
        } else {
            $previousId = null;
        }

        echo $this->twig->render('article.html.twig', [
            'article'=>$article,
            'articles'=>$this->articles,
            'comments'=>$comments,
            'nextId'=>$nextId,
            'previousId'=>$previousId,
            'navAdmin'=>$navAdmin
        ]);
    }

    /**
     * What we do if we are on login page
     */
    public function loginPage(){
        //If user is log -> he's redirected to admin
        if($this->authClass->logged()){
            echo $this->adminHomePage();
        } else {
            //If he's not log, he need to log in
            if(!empty($_POST)){
                if($this->authClass->login(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password'])) === true){
                    header('Location: /web/index.php/admin/home/');
                } else {
                    echo '<h6 id="badCredentials">Bad Credentials</h6>';
                }
            }
            echo $this->twig->render('login.html.twig');
        }
    }

    /**
     * What we do if we are on admin page (home)
     */
    public function adminHomePage(){
        if ($this->authClass->logged()){
            echo $this->twig->render('home_admin.html.twig');
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (add an article)
     */
    public function adminAddArticlePage(){
        //Get pictures from gallery
        $allImg = [];
        $allImgDirectory = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload";
        $dir = opendir($allImgDirectory);
        while($file = readdir($dir)){
            $format = strtolower(substr($file,-3,3));
            $allow_format = ['jpg', 'png', 'gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $allImg [] = $file;
            }
        }
        
        //Add an article
        if (!empty($_POST['title']) && !empty($_POST['summary']) && !empty($_POST['content'])) {
            if (strlen($_POST['title']) < 100){
                $this->articleClass->addAnArticle();
                if ($this->articleClass->getAddAnArticle() === true) {
                    $this->flash->setFlash('Votre article a bien été ajouté.', 'green lighten-2');
                    header('Location: /web/index.php/admin/articles?p=1');
                } else {
                    $this->flash->setFlash('Une erreur est survenue lors de l\'envoi. Veuillez réessayer.', 'red lighten-2');
                    $this->flash->getFlash();
                }
            } else {
                $this->flash->setFlash('Le titre de l\'article est trop long.', 'red lighten-2');
                $this->flash->getFlash();
            }
        } else {
            $this->flash->setFlash('Le formulaire n\'est pas correctement renseigné.', 'red lighten-2');
            $this->flash->getFlash();
        }


        if ($this->authClass->logged()){
            echo $this->twig->render('addArticle_admin.html.twig', [
                'allImg'=>$allImg
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (edit an article)
     */
    public function adminEditArticlePage(){
        // Display article to prefill form
        $article = $this->articleClass->getArticleById();

        //Get pictures from gallery
        $allImg = [];
        $allImgDirectory = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload";
        $dir = opendir($allImgDirectory);
        while($file = readdir($dir)){
            $format = strtolower(substr($file,-3,3));
            $allow_format = ['jpg', 'png', 'gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $allImg [] = $file;
            }
        }

        // Update an article
        if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['content'])){
            if (strlen($_POST['title']) < 100) {
                $this->articleClass->updateAnArticle();
                if ($this->articleClass->getUpdateAnArticle() === true) {
                    $this->flash->setFlash('Votre article a bien été modifié.', 'green lighten-2');
                    header('Location: /web/index.php/admin/articles?p=1');
                } else {
                    $this->flash->setFlash('Une erreur est survenue. Votre article n\'a pas été modifié. Veuillez réessayer', 'red lighten-2');
                    $this->flash->getFlash();
                }
            } else {
                $this->flash->setFlash('Le titre de l\'article est trop long.', 'red lighten-2');
                $this->flash->getFlash();
            }
        } else {
            $this->flash->setFlash('Le formulaire n\'est pas correctement renseigné.', 'red lighten-2');
            $this->flash->getFlash();
        }

        if ($this->authClass->logged()){
            echo $this->twig->render('editArticle_admin.html.twig', ['article'=>$article, 'allImg'=>$allImg]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * Whate we do if we are on admin page (delete an article)
     */
    public function adminDeleteArticlePage(){
        if ($this->authClass->logged()){
            $this->articleClass->deleteAnArticle();
            header('Location: /web/index.php/admin/articles?p=1');
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (add an article)
     */
    public function adminArticlesPage(){
        $this->flash->getFlash();

        //How many articles are there in BDD ?
        $nbArt = count($this->articles);
        //How many pages are we displaying ?
        $nbPages = ceil($nbArt/10);
        $curPage = $_GET['p'];

        $articlesWhithPagination = $this->articleClass->getArticlesWhithPagination();

        if ($this->authClass->logged()){
            echo $this->twig->render('articles_admin.html.twig', [
                //'articles'=>$this->articles,
                'articlesWhitPagination'=>$articlesWhithPagination,
                'nbPages'=>$nbPages,
                'curPage'=>$curPage
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (comments)
     */
    public function adminCommentsPage(){
        if ($this->authClass->logged()){
            echo $this->twig->render('comments_admin.html.twig');
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (my account)
     */
    public function adminAccountPage(){
        if ($this->authClass->logged()){
            echo $this->twig->render('account_admin.html.twig');
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (pictures)
     */
    public function adminPicturesPage(){
        //To delete a picture
        if (isset($_GET['n'])){
            $img = $_GET['n'];
            if (in_array($img, scandir('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/'))){
                unlink('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/'.$img);
            }
        }

        //We add a picture in gallery if file field isn't empty
        if(!empty($_FILES)){
            $picture = $_FILES['picture'];
            $format = strtolower(substr($picture['name'],-4,4));
            $allow_format = ['.jpg', '.png', '.gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $tmp_namp = $picture['tmp_name'];
                $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/".$picture['name'];
                move_uploaded_file($tmp_namp, $destination_file);

            } else {
                echo '<div>Le fichier que vous essayez d\'envoyer n\'est pas une image.</div>';
            }
        }

        //We add a picture in gallery if text field isn't empty
        if(!empty($_POST)){
            $pictureUrl = $_POST['picture-url'];
            $format = strtolower(substr($pictureUrl,-4,4));
            $allow_format = ['.jpg', '.png', '.gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $urlExplode = explode("/", $pictureUrl);
                $name = $urlExplode[sizeof($urlExplode)-1];
                $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/".$name;
                copy($pictureUrl, $destination_file);
            }
        }

        //We store images in an array in order to send and display them in view
        $allImg = [];
        $allImgDirectory = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload";
        $dir = opendir($allImgDirectory);
        while($file = readdir($dir)){
            $format = strtolower(substr($file,-3,3));
            $allow_format = ['jpg', 'png', 'gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $allImg [] = $file;
            }
        }

        echo $this->twig->render('pictures_admin.html.twig', [
            "allImg"=>$allImg
        ]);
    }

    /**
     * What we do if we are on error page
     */
    public function errorPage()
    {
        header('HTTP/1.1 404 Not Found');
        echo $this->twig->render('error404.html.twig');
    }

}