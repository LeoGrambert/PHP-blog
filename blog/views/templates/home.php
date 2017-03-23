<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 15:15
 */

$title = "Accueil";

ob_start();

echo $posts;
?>
    Voir une page article : <a href="/web/index.php/show?id=1">Cliquez ici</a> (message issu de la vue)
<?php

$content = ob_get_clean();

include 'layout.php';
