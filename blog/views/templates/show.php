<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 15:20
 */

$title = "Page article";

ob_start();

echo $post;

$content = ob_get_clean();

include 'layout.php';