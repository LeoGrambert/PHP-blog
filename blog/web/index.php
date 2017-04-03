<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

use src\Autoloader;
use src\Table\Article;
use src\Table\Comment;

// load and initialize any global libraries
require_once '../vendor/autoload.php';
require '../src/Autoloader.php';
require '../app/App.php';

// load autoloader
Autoloader::register();

// load twig
$loader = new Twig_Loader_Filesystem('../views/templates');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));

//query to get all articles
$articles = Article::getArticles();


// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//If homepage
if ('/web/index.php' === $uri || '/web/' === $uri) {
    echo $twig->render('home.html.twig', ['articles'=>$articles]);
}
//If article page
elseif ('/web/index.php/article' === $uri && isset($_GET['id'])) {
    //query to get article by id
    $article = Article::getArticleById();

    //query to add a comment
    if(isset($_POST['content']) && !empty($_POST['content']))
    {
        $addAComment = Comment::addComment();
    } else {
    }

    //query to get all comments by article id
    $comments = Comment::getComments();
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

} elseif ('/web/index.php/admin' === $uri){
    echo $twig->render('admin.html.twig');


} else {
    header('HTTP/1.1 404 Not Found');
    echo $twig->render('error404.html.twig');
}


