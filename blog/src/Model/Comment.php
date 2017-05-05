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
    private $isAdministrator;

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function isAdministrator(){
        return $this->isAdministrator;
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
    public function getPicture(){
        $user = new User();
        $picture = $user->displayPicture();

        if ($this->isAdministrator == 1){
            return $picture[0]->getPicture();
        } else {
            if ($this->email != null) {
                $email = md5($this->getEmail());
                $email = strtolower($email);
                $gravatar = 'https://www.gravatar.com/avatar/' . $email;
            } else {
                $gravatar = null;
            }
            return $gravatar;
        }
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
        $authDb = new AuthDb(App::getDatabase());
        $user = new User();
        $username = $user->displayUsername();

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
            //If administrator is logged, we use his profile
            if ($authDb->logged()){
                return App::getDatabase()
                    ->prepare(
                        'INSERT INTO Comment (article_id, author, content, parent_comment_id, email, depth, isAdministrator) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)',
                        ([
                            $_GET['id'],
                            $username[0]->getUsername(),
                            htmlspecialchars($_POST['content']),
                            $parent_id,
                            htmlspecialchars($_POST['email']),
                            $depth,
                            true
                        ]),
                        __CLASS__
                    );
            //If he's not logged, we use visitors informations (from forms)
            } else {
            return App::getDatabase()
                ->prepare(
                    'INSERT INTO Comment (article_id, author, content, parent_comment_id, email, depth) 
                     VALUES (?, ?, ?, ?, ?, ?)',
                    ([
                        $_GET['id'],
                        $author,
                        htmlspecialchars($_POST['content']),
                        $parent_id,
                        htmlspecialchars($_POST['email']),
                        $depth
                    ]),
                    __CLASS__
                );
            }
        }
    }

    /**
     * Query to report a comment
     * @return array|mixed
     */
    public function reportComment(){
        $id = $_POST['comment-id'];
        $_SESSION['report'] [] = $id;
        return App::getDatabase()
            ->prepare(
                'UPDATE Comment SET report = report+1 WHERE id='.$id,
                [$_POST['comment-id']],
                __CLASS__                
            );
    }

    /**
     * Query to delete a comment
     * @return array|mixed
     */
    public function deleteComment(){
        return App::getDatabase()
            ->prepare(
                'DELETE FROM Comment WHERE id = ?',
                [$_POST['id']],
                __CLASS__
            );
    }

    /**
     * Query to get all comments with report
     * @return array
     */
    public function getCommentsWithReport(){
        if(isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= count($this->getNumberReportedComments())){
            $curPage = $_GET['p'];
        } else {
            $curPage = 1;
        }
        $perPage = 10;
        
        return App::getDatabase()
            ->query(
                'SELECT * FROM Comment WHERE report != 0 ORDER BY report DESC LIMIT '.(($curPage-1)*$perPage).','.$perPage,
                __CLASS__
            );
    }

    /**
     * Get number of reported comments
     * @return array
     */
    public function getNumberReportedComments(){
        return App::getDatabase()
            ->query('SELECT id FROM Comment WHERE report != 0', __CLASS__);
    }
}