<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

use src\Autoloader;
use src\Database;

// load and initialize any global libraries
require_once '../vendor/autoload.php';
require '../src/Autoloader.php';

// load autoloader
Autoloader::register();

// load twig
$loader = new Twig_Loader_Filesystem('../views/templates');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));

//initialize database
$db = new Database('blog_JF');

//query to get all articles
$articles = $db->query('SELECT * FROM Article', 'src\Table\Article');

//query to get article by id
$article = $db->prepare('SELECT * FROM Article WHERE id = ?', [$_GET['id']], 'src\Table\Article', true);

// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/web/index.php' === $uri || '/web' === $uri || '/web/' === $uri) {
    echo $twig->render('home.html.twig', ['articles'=>$articles]);
} elseif ('/web/index.php/article' === $uri && isset($_GET['id'])) {
    echo $twig->render('article.html.twig', ['article'=>$article]);
} elseif ('/web/index.php/admin' === $uri){
    echo $twig->render('admin.html.twig');
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}


