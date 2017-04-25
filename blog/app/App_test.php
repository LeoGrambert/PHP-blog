<?php
/**
 * User: leo
 * Date: 28/03/17
 * Time: 10:02
 */

namespace app;

use src\Autoloader;
use src\Database;

/**
 * Class App_test
 * @package app
 * *********************************************************
 * This file is the configuration file of this site. 
 * Use it by adapting the login credentials to your database.
 * If you need, contact me here : leo@grambert.fr
 * *********************************************************
 */
class App_test
{
    const DB_NAME = 'blog_JF';
    const DB_USER = 'your_username';
    const DB_PASS = 'your_password';
    const DB_HOST = 'your_host';

    private static $_database;

    /**
     * Use Singleton
     * @return Database
     */
    public static function getDatabase(){
        if (is_null(self::$_database)){
            self::$_database = new Database(self::DB_NAME, self::DB_USER, self::DB_PASS, self::DB_HOST);
        }
        return self::$_database;
    }

    public function forbidden(){
        header('HTTP/1.0 403 Forbidden');
        die('Accès interdit, <a href="/web/index.php/login/">veuillez vous authentifier</a>');
    }

    /**
     * Initialize session and load autoloader
     */
    public static function load(){
        session_start();
        // load and initialize any global libraries
        require_once '../vendor/autoload.php';
        require '../src/Autoloader.php';
        // load autoloader
        Autoloader::register();
    }

    /**
     * Load Twig
     * @return \Twig_Environment
     */
    public static function twig(){
        $loader = new \Twig_Loader_Filesystem('../views/templates');
        $twig = new \Twig_Environment($loader, array(
            'auto_reload' => true
        ));
        return $twig;
    }

}