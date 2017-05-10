<?php
/**
 * User: leo
 * Date: 25/03/17
 * Time: 15:18
 */

namespace src;

use \PDO;

/**
 * We use this class in order to connect at database and make SQL queries
 * Class Database
 * @package src
 */
class Database
{
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    /**
     * Database constructor.
     * @param $db_name
     * @param $db_user
     * @param $db_pass
     * @param $db_host
     */
    public function __construct($db_name, $db_user, $db_pass, $db_host){
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_pass = $db_pass;
        $this->db_user = $db_user;
    }

    /**
     * @return PDO
     */
    private function getPDO(){
        if($this->pdo === null){
            $pdo = new PDO('mysql:dbname='.$this->db_name.';host='.$this->db_host, $this->db_user, $this->db_pass, [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    /**
     * @param $statement
     * @param $class_name
     * @param bool $one
     * @return array
     */
    public function query($statement, $class_name = null, $one = false){
        $req = $this->getPDO()->query($statement);
        if($class_name === null)
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if ($one)
        {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }

    /**
     * @param $statement
     * @param $attributes
     * @param $class_name
     * @param bool $one
     * @return array|mixed
     */
    public function prepare($statement, $attributes, $class_name = null, $one = null){
        $req = $this->getPDO()->prepare($statement);
        $req->execute($attributes);
        if($class_name === null)
        {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        if($one === true){
            $datas = $req->fetch();
            return $datas;
        } elseif ($one === false) {
            $datas = $req->fetchAll();
            return $datas;
        }
    }

    /**
     * @return string
     */
    public function lastInsertId(){
        return $this->getPDO()->lastInsertId();
    }
}