<?php

/**
 * User: leo
 * Date: 23/03/17
 * Time: 22:01
 */

namespace app;

/**
 * Class Autoloader
 * @package LG\app
 */
class Autoloader
{
    static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }


    static function autoload($class_name)
    {
        if (strpos($class_name, __NAMESPACE__.'\\') === 0){
            $class_name = str_replace(__NAMESPACE__.'\\', '', $class_name);
            $class_name = str_replace('\\', '/', $class_name);
            require __DIR__.$class_name.'.php';
        }
    }
}