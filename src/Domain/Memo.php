<?php

namespace Classy\Domain;

class Memo 
{
    /**
     * Memo id.
     *
     * @var integer
     */
    private $id;

    /**
     * Memo title.
     *
     * @var string
     */
    private $title;

    /**
     * Memo content.
     *
     * @var string
     */
    private $content;

    /**
     * Memo date.
     *
     * @var string
     */
    private $date;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getNowDate() {
        $todayDate = date("Y-m-d");        
        $this->date = $todayDate;
        return $todayDate;
    }

}