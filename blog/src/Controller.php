<?php
/**
 * User: leo
 * Date: 04/04/17
 * Time: 11:28
 */

namespace src;

use app\App;
use src\Table\Article;
use src\Table\Comment;


class Controller
{
    private $twig;
    private $articleClass;
    private $commentClass;
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
        if(isset($_POST['content']) && !empty($_POST['content']))
        {
            $this->commentClass->addComment();
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

        echo $this->twig->render('article.html.twig', [
            'article'=>$article,
            'comments'=>$comments
        ]);
    }

    /**
     * What we do if we are on admin page
     */
    public function adminPage(){
        echo $this->twig->render('admin.html.twig');
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