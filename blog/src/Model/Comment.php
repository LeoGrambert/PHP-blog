<?php
/**
 * User: leo
 * Date: 28/03/17
 * Time: 11:17
 */

namespace src\Model;

use app\App;

/**
 * Class Comment
 * @package src\Model
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
     * Query to get all comments in an article
     * @return array|mixed
     */
    public function getComments(){
        return App::getDatabase()
            ->prepare(
                'SELECT * FROM Comment WHERE article_id = ? ORDER BY date_add DESC',
                [$_GET['id']],
                __CLASS__,
                false
            );
    }

    /**
     * Query to add a comment
     * NB: If author field is empty, we display 'anonyme'
     * NB: Only if depth is less than 3, we add a comment in DBB
     * @return array|mixed
     * @throws \Exception
     */
    public function addComment(){
        //If author field is empty, we display 'anonyme'
        if (empty($_POST['author'])){
            $author = 'Anonyme';
        } else {
            $author = htmlspecialchars(implode([$_POST['author']]));
        }

        //We select parent comment id and we calculate the response depth
        $parent_id = isset($_POST['parent_comment_id']) ? $_POST['parent_comment_id'] : 0;
        $depth = 0;
        if ($parent_id != 0){
            $comment = App::getDatabase()
                ->prepare(
                    'SELECT id, depth FROM Comment WHERE id = ?',
                    [$parent_id],
                    __CLASS__,
                    true
                    );
            if ($comment == false){
                throw new \Exception('Ce parent n\'existe pas');
            }
            $depth = $comment->depth + 1;
        }

        //If depth is less than 3, we add a comment in DBB
        if($depth > 3){
            throw new \Exception('Impossible d\'avoir plus de 3 sous niveaux de réponse');
        } else {
            return App::getDatabase()
                ->prepare(
                    'INSERT INTO Comment (article_id, author, content, parent_comment_id, email, depth) 
                 VALUES (?, ?, ?, ?, ?, ?)',
                    ([
                        implode([$_GET['id']]),
                        $author,
                        htmlspecialchars(implode([$_POST['content']])),
                        $parent_id,
                        htmlspecialchars(implode([$_POST['email']])),
                        $depth
                    ]),
                    __CLASS__
                );
        }
    }
}