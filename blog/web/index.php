<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

use src\Autoloader;
use src\Table\Article;

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

//query to get article by id
$article = Article::getArticleById();

// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/web/index.php' === $uri || '/web/' === $uri) {
    echo $twig->render('home.html.twig', ['articles'=>$articles]);
} elseif ('/web/index.php/article' === $uri && isset($_GET['id'])) {
    echo $twig->render('article.html.twig', ['article'=>$article]);
} elseif ('/web/index.php/admin' === $uri){
    echo $twig->render('admin.html.twig');
} else {
    header('HTTP/1.1 404 Not Found');
    echo $twig->render('error404.html.twig');
}


