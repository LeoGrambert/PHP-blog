<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 14:54
 */

// load and initialize any global libraries
require_once '../src/model.php';
require_once '../src/controllers.php';

// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ('/web/index.php' === $uri) {
    list_action();
} elseif ('/web/index.php/show' === $uri && isset($_GET['id'])) {
    show_action($_GET['id']);
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}


