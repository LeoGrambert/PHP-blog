<?php

/**
 * User: leo
 * Date: 25/03/17
 * Time: 15:56
 */

namespace src\Table;

/**
 * Class Article
 * @package src\Table
 */
class Article
{
    private $id;
    private $date_add;
    private $title;
    private $summary;
    private $content;
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
     * 
     */
    public function setDateAdd(){
        $date_add = new \DateTime();
        $this->date_add = $date_add;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title){
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param $summary
     */
    public function setSummary($summary){
        $this->summary = $summary;
    }

    /**
     * @return mixed
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content){
        $this->content = $content;
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
     */
    public function setIsPublished($is_published){
        $this->is_published = $is_published;
    }
}