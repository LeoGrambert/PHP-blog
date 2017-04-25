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
    private $picture;

    /**
     * @return mixed
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPicture(){
        return $this->picture;
    }

    /**
     * Query to get username
     * @return mixed
     */
    public function displayUsername(){
        return App::getDatabase()
            ->query(
                'SELECT username FROM User WHERE id=1',
                __CLASS__
            );
    }

    /**
     * Query to change username
     * @return mixed
     */
    public function setUsername(){
        return App::getDatabase()
            ->prepare(
                'UPDATE User SET username = ? WHERE id=1',
                [htmlspecialchars($_POST['username'])],
                __CLASS__
            );
    }

    /**
     * Query to change password
     * @return array|mixed
     */
    public function setPassword(){
        return App::getDatabase()
            ->prepare(
                'UPDATE User SET password = ? WHERE id = 1',
                [htmlspecialchars(md5($_POST['password']))],
                __CLASS__
            );
    }

    /**
     * Query to get picture
     * @return array
     */
    public function displayPicture(){
        return App::getDatabase()
            ->query(
                'SELECT picture FROM User WHERE id=1',
                __CLASS__
            );
    }

    /**
     * Query to change profile picture
     * @return array|mixed
     */
    public function setPicture(){
        return App::getDatabase()
            ->prepare(
                'UPDATE User SET picture = ? WHERE id=1',
                [htmlspecialchars($_POST['picture'])],
                __CLASS__
            );
    }
}