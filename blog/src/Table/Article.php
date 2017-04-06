<?php

/**
 * User: leo
 * Date: 25/03/17
 * Time: 15:56
 */

namespace src\Table;

use app\App;

/**
 * Class Article
 * @package src\Table
 */
class Article
{
    private $id;
    private $date_add;
    private $content;
    private $title;
    private $summary;
    private $picture;
    private $is_published;

    /**
     * @return string
     */
    public function getUrl(){
        return 'index.php/article?id='.$this->id;
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
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
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param $summary
     * @return $this
     */
    public function setSummary($summary){
        $this->summary = $summary;
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
     * @return string
     */
    public function isPublished(){
        $state = $this->is_published;
        if($state == 0){
            return "Brouillon";
        } elseif ($state == 1){
            return "Publié";
        } else{
            return "Erreur";
        }
    }

    /**
     * @param $is_published
     * @return $this
     */
    public function setIsPublished($is_published){
        $this->is_published = $is_published;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPicture(){
        return $this->picture;
    }

    /**
     * @param $picture
     * @return $this
     */
    public function setPicture($picture){
        $this->picture = $picture;
        return $this;
    }

    /**
     * Query to get all articles
     * @return array
     */
    public function getArticles(){
        return App::getDatabase()
            ->query(
                'SELECT * FROM Article ORDER BY date_add DESC',
                __CLASS__
            );
    }

    /**
     * Query to get article by id
     * @return array|mixed
     */
    public function getArticleById(){
        return App::getDatabase()
            ->prepare(
                'SELECT * FROM Article WHERE id = ?',
                [$_GET['id']],
                __CLASS__,
                true
            );
    }

    /**
     * This method return an array with the next id.
     * @return array
     */
    public function getNextArticle(){
        $currentId = $_GET['id'];
        $nextArticle = App::getDatabase()
            ->query('SELECT Article.id FROM Article ORDER BY Article.id LIMIT '.$currentId.', 1',
                __CLASS__
            );
        return $nextArticle;
    }

    /**
     * This method return an array with all id to the displayed item
     * @return array
     */
    public function getPreviousArticle(){
        $currentId = $_GET['id'];
        $previousArticles = App::getDatabase()
            ->query('SELECT Article.id FROM Article ORDER BY Article.id LIMIT '.$currentId,
                __CLASS__
            );
        return $previousArticles;
    }
}