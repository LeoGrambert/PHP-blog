<?php
/**
 * User: leo
 * Date: 28/03/17
 * Time: 11:17
 */

namespace src\Table;

use app\App;

/**
 * Class Comment
 * @package src\Table
 */
class Comment
{
    private $id;
    private $article_id;
    private $date_add;
    private $content;
    private $author;
    private $report;
    private $parent_comment_id;
    private $email;

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getArticleId(){
        return $this->article_id;
    }

    /**
     * @return mixed
     */
    public function getDateAdd(){
        return $this->date_add;
    }

    /**
     * @return mixed
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * @param $author
     * @return $this
     */
    public function setAuthor($author){
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content){
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReport(){
        return $this->report;
    }

    /**
     * @return $this
     */
    public function newReport(){
        $this->report = $this->report++;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentCommentId(){
        return $this->parent_comment_id;
    }

    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Method to generate Gravatar
     * @return string
     */
    public function getGravatar(){
        if ($this->email != null){
            $email = md5($this->getEmail());
            $email = strtolower($email);
            $gravatar = 'https://www.gravatar.com/avatar/'.$email;
        } else {
            $gravatar = null;
        }
        return $gravatar;
    }

    /**
     * @param $parent_comment_id
     * @return $this
     */
    public function setParentCommentId($parent_comment_id){
        $this->parent_comment_id = $parent_comment_id;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public static function getComments(){
        return App::getDatabase()
            ->prepare(
                'SELECT * FROM Comment WHERE article_id = ?',
                [$_GET['id']],
                __CLASS__,
                false
            );
    }

    /**
     * @return array|mixed
     */
    public static function addComment(){
        return App::getDatabase()
            ->prepare(
                'INSERT INTO Comment SET author = ?, content = ?, email = ?',
                ([
                    $_POST['author'],
                    $_POST['content'],
                    $_POST['email']
                ]),
                __CLASS__,
                true
            );
    }
}