<?php
/**
 * User: leo
 * Date: 23/03/17
 * Time: 16:30
 */

function list_action()
{
    $posts = get_all_posts();
    require '../views/templates/home.php';
}

function show_action($id)
{
    $post = get_post_by_id($id);
    require '../views/templates/show.php';
}