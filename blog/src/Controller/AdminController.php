<?php
/**
 * User: leo
 * Contact: leo@grambert.fr
 * Date: 08/05/17
 * Time: 16:44
 * Create whith: PhpStorm
 */

namespace src\Controller;

use app\App;
use src\Model\Article;
use src\Model\AuthDb;
use src\Model\Comment;
use src\Model\FlashMsg;
use src\Model\User;

class AdminController
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
     * What do we do if we are on admin page (home)
     */
    public function adminHomePage(){
        if ($this->authClass->logged()){
            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];
            echo $this->twig->render('home_admin.html.twig', [
                "username"=>$username,
                "picture"=>$picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (add an article)
     */
    public function adminAddArticlePage(){

        if ($this->authClass->logged()){
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
            if (isset($_POST['title']) && isset($_POST['summary']) && isset($_POST['content'])){
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
            }

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            echo $this->twig->render('addArticle_admin.html.twig', [
                'allImg'=>$allImg,
                'username'=>$username,
                'picture'=>$picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (edit an article)
     */
    public function adminEditArticlePage(){

        if ($this->authClass->logged()){
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
                if (!empty($_POST['title']) && !empty($_POST['summary']) && !empty($_POST['content'])) {
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
            }

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            echo $this->twig->render('editArticle_admin.html.twig', [
                'article'=>$article,
                'allImg'=>$allImg,
                'username'=>$username,
                'picture'=>$picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (delete an article)
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
     * What do we do if we are on admin page (delete a comment)
     */
    public function adminDeleteCommentPage(){
        if ($this->authClass->logged()){
            $this->commentClass->deleteComment();
            header('Location: /web/index.php/admin/comments?p=1');
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (add an article)
     */
    public function adminArticlesPage(){

        if ($this->authClass->logged()){
            $this->flash->getFlash();

            //How many articles are there in BDD ?
            $articles = $this->articleClass->getArticles();
            $nbArt = count($articles);
            //How many pages are we displaying ?
            $nbPages = ceil($nbArt/10);
            $curPage = $_GET['p'];

            $articlesWhithPagination = $this->articleClass->getArticlesAdmin();

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            echo $this->twig->render('articles_admin.html.twig', [
                'articles'=>$articlesWhithPagination,
                'nbPages'=>$nbPages,
                'curPage'=>$curPage,
                'username'=>$username,
                'picture'=>$picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (comments)
     */
    public function adminCommentsPage(){

        if ($this->authClass->logged()){
            //How many articles are there in BDD ?
            $nbComments = count($this->commentClass->getNumberReportedComments());
            //How many pages are we displaying ?
            $nbPages = ceil($nbComments/10);
            $curPage = $_GET['p'];
            //Get all comments with report
            $commentsWithReport = $this->commentClass->getCommentsWithReport();

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            echo $this->twig->render('comments_admin.html.twig',
                [
                    'commentsWithReport'=>$commentsWithReport,
                    'nbPages'=>$nbPages,
                    'curPage'=>$curPage,
                    'username'=>$username,
                    'picture'=>$picture
                ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (my account)
     */
    public function adminAccountPage(){
        if ($this->authClass->logged()){

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

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            //Change username
            if(isset($_POST['username']) && !empty($_POST['username']) && $_POST['username'] != " "){
                $this->userClass->setUsername();
                header('Location: /web/index.php/admin/account/');
            }

            //Change password
            if(isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['password-confirmation']) && !empty($_POST['password-confirmation'])){
                if (isset($_POST['old-password']) && $this->userClass->getPassword() != md5($_POST['old-password'])){
                    $this->flash->setFlash('Votre mot de passe actuel n\'est pas correct.', 'red lighten-2');
                    $this->flash->getFlash();
                } else {
                    if (md5($_POST['password']) != md5($_POST['password-confirmation'])){
                        $this->flash->setFlash('Les mots de passe ne coincident pas', 'red lighten-2');
                        $this->flash->getFlash();
                    } elseif (md5($_POST['password']) == md5($_POST['password-confirmation'])) {
                        $this->userClass->setPassword();
                        $this->flash->setFlash('Votre mot de passe a été actualisé.', 'green lighten-2');
                        $this->flash->getFlash();
                    }
                }
            }

            //Change picture
            if(isset($_POST['picture'])){
                $this->userClass->setPicture();
                header('Location: /web/index.php/admin/account/');
            }

            echo $this->twig->render('account_admin.html.twig', [
                'allImg'=>$allImg,
                'username'=>$username,
                'picture'=>$picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we are on admin page (pictures)
     */
    public function adminPicturesPage(){
        if ($this->authClass->logged()) {
            //To delete a picture
            if (isset($_GET['n'])) {
                $img = $_GET['n'];
                if (in_array($img, scandir('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/'))) {
                    unlink('/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/' . $img);
                    header('Location: /web/index.php/admin/pictures');
                } else {
                    $this->flash->setFlash('L\'image n\'a pas pu être supprimé', 'red lighten-2');
                    $this->flash->getFlash();
                }
            }

            //We add a picture in gallery if file field isn't empty
            if (!empty($_FILES)) {
                $picture = $_FILES['picture'];
                $format = strtolower(substr($picture['name'], -4, 4));
                $allow_format = ['.jpg', '.png', '.gif', 'jpeg'];
                if (in_array($format, $allow_format)) {
                    $tmp_namp = $picture['tmp_name'];
                    $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/" . $picture['name'];
                    move_uploaded_file($tmp_namp, $destination_file);
                    $this->flash->setFlash('L\'image a bien été ajoutée', 'green lighten-2');
                    $this->flash->getFlash();
                } else {
                    $this->flash->setFlash('Le format du fichier n\'est pas adapté (seuls .png .jpg .gif sont acceptés)', 'red lighten-2');
                    $this->flash->getFlash();
                }
            }

            //We add a picture in gallery if text field isn't empty
            if (!empty($_POST)) {
                $pictureUrl = $_POST['picture-url'];
                $format = strtolower(substr($pictureUrl, -4, 4));
                $allow_format = ['.jpg', '.png', '.gif', 'jpeg'];
                if (in_array($format, $allow_format)) {
                    $urlExplode = explode("/", $pictureUrl);
                    $name = $urlExplode[sizeof($urlExplode) - 1];
                    $destination_file = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload/" . $name;
                    copy($pictureUrl, $destination_file);
                    $this->flash->setFlash('L\'image a bien été ajoutée', 'green lighten-2');
                    $this->flash->getFlash();
                } else {
                    $this->flash->setFlash('Le format du fichier n\'est pas adapté (seuls .png .jpg .gif sont acceptés)', 'red lighten-2');
                    $this->flash->getFlash();
                }
            }

            //We store images in an array in order to send and display them in view
            $allImg = [];
            $allImgDirectory = "/home/leo/Documents/Dev/formaCPMDev_Blog/blog/web/img/upload";
            $dir = opendir($allImgDirectory);
            while ($file = readdir($dir)) {
                $format = strtolower(substr($file, -3, 3));
                $allow_format = ['jpg', 'png', 'gif', 'jpeg'];
                if (in_array($format, $allow_format)) {
                    $allImg [] = $file;
                }
            }

            //Get username & picture
            $username = $this->userClass->displayUsername();
            $picture = $this->userClass->displayPicture();
            $username = $username[0];
            $picture = $picture[0];

            echo $this->twig->render('pictures_admin.html.twig', [
                "allImg" => $allImg,
                'username' => $username,
                'picture' => $picture
            ]);
        } else {
            $this->appClass->forbidden();
        }
    }

    /**
     * What do we do if we want to disconnect us
     */
    public function adminDisconnectPage(){
        session_destroy();
        header('Location: /web/index.php?p=1');
    }
    
}