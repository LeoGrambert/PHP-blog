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
use Plasticbrain\FlashMessages\FlashMessages;


class Controller
{
    private $twig;
    private $articleClass;
    private $commentClass;
    private $appClass;
    private $authClass;
    private $articles;

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
    }

    /**
     * What we do if we are on home page
     */
    public function homePage(){
        echo $this->twig->render('home.html.twig', ['articles'=>$this->articles]);
    }

    /**
     * What we do if we are on article page
     */
    public function articlePage(){
        //query to get article by id
        $article = $this->articleClass->getArticleById();

        //query to add a comment
        $msg = new FlashMessages();
        if(isset($_POST['content'])){
            if(!empty($_POST['content']))
            {
                $this->commentClass->addComment();
            } else {
                $msg->error('Le commentaire n\'a pas pu être publié. Veuillez réessayer ultérieurement.');
                $msg->display();
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
            'previousId'=>$previousId
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
        //Add an article
        if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['content'])){
            $this->articleClass->addAnArticle();
        }

        if ($this->authClass->logged()){
            echo $this->twig->render('addArticle_admin.html.twig');
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

        // Update an article
        if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['content'])){
            $this->articleClass->updateAnArticle();
        }

        if ($this->authClass->logged()){
            echo $this->twig->render('editArticle_admin.html.twig', ['article'=>$article]);
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
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What we do if we are on admin page (add an article)
     */
    public function adminArticlesPage(){
        if ($this->authClass->logged()){
            echo $this->twig->render('articles_admin.html.twig', [
                'articles'=>$this->articles
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
            if (in_array($img, scandir('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/'))){
                unlink('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/'.$img);
            }
        }

        //We add a picture in gallery if file field isn't empty
        if(!empty($_FILES)){
            $picture = $_FILES['picture'];
            $format = strtolower(substr($picture['name'],-4,4));
            $allow_format = ['.jpg', '.png', '.gif', 'jpeg'];
            if (in_array($format, $allow_format)){
                $tmp_namp = $picture['tmp_name'];
                $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/".$picture['name'];
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
                $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/".$name;
                copy($pictureUrl, $destination_file);
            }
        }

        //We store images in an array in order to send and display them in view
        $allImg = [];
        $allImgDirectory = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img";
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