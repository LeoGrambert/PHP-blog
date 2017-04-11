<?php
/**
 * User: leo
 * Date: 11/04/17
 * Time: 10:22
 */

namespace src\Model;

use src\Database;

class AuthDb
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * @param $username
     * @param $password
     * @return boolean
     */
    public function login($username, $password)
    {
        $user = $this->db->prepare('SELECT * FROM User WHERE username = ?', [$username], null, true);
        var_dump($user);
    }

    public function logged(){
        return isset($_SESSION['auth']);
    }
}