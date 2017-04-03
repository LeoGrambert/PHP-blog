<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

use app\App;
use src\Table\Article;
use src\Table\Comment;

/*
 * Load what we need
 *
 */
//call load app function -> initialize session and load autoloader
require '../app/App.php';
App::load();
//load twig
$twig = App::twig();
//load class
$articleClass = new Article();
$commentClass = new Comment();


//query to get all articles
$articles = $articleClass->getArticles();


/*
 * Router
 *
 */
// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//If homepage
if ('/web/index.php' === $uri || '/web/' === $uri) {
    echo $twig->render('home.html.twig', ['articles'=>$articles]);
}

//If article page
elseif ('/web/index.php/article' === $uri && isset($_GET['id'])) {
    //query to get article by id
    $article = $articleClass->getArticleById();

    //query to add a comment
    if(isset($_POST['content']) && !empty($_POST['content']))
    {
        $addAComment = $commentClass->addComment();
    } else {
    }

    //query to get all comments by article id
    $comments = $commentClass->getComments();
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

    echo $twig->render('article.html.twig', [
        'article'=>$article,
        'comments'=>$comments
    ]);

//If admin page
} elseif ('/web/index.php/admin' === $uri){
    echo $twig->render('admin.html.twig');

//If not => 404
} else {
    header('HTTP/1.1 404 Not Found');
    echo $twig->render('error404.html.twig');
}


