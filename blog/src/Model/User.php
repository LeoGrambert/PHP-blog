<?php
/**
 * User: leo
 * Contact: leo@grambert.fr
 * Date: 24/04/17
 * Time: 18:48
 * Create whith: PhpStorm
 */

namespace src\Model;

use app\App;

/**
 * Class User
 * @package src\Model
 */
class User
{
    private $username;
    private $password;

    /**
     * @return mixed
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * Query to get username
     * @return mixed
     */
    public function displayUsername(){
        return App::getDatabase()
            ->query(
                'SELECT username FROM User',
                __CLASS__
            );
    }

    /**
     * @param $username
     * @return mixed
     */
    public function setUsername($username){
        $this->username = $username;
        return $username;
    }
}