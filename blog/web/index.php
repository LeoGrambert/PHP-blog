<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

// load and initialize any global libraries
require_once '../src/model.php';
require_once '../vendor/autoload.php';

// load twig
$loader = new Twig_Loader_Filesystem('../views/templates');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));

// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ('/web/index.php' === $uri || '/web' === $uri || '/web/' === $uri || '/' === $uri) {
    echo $twig->render('home.html.twig');
} elseif ('/web/index.php/article' === $uri && isset($_GET['id'])) {
    echo $twig->render('article.html.twig');
} elseif ('/web/index.php/admin' === $uri){
    echo $twig->render('admin.html.twig');
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}


