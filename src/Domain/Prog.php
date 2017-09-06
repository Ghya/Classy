<?php

namespace Classy\Domain;

class Prog 
{
    /**
     * prog id.
     *
     * @var integer
     */
    private $id;

    /**
     * prog subject.
     *
     * @var \Classy\Domain\Subject
     */
    private $subject;

    /**
     * prog content.
     *
     * @var string
     */
    private $content;

    /**
     * prog period.
     *
     * @var int
     */
    private $period;

    /**
     * Associated class.
     *
     * @var \Classy\Domain\Classe
     */
    private $class;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject(Subject $subject) {
        $this->subject = $subject;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getPeriod() {
        return $this->period;
    }

    public function setPeriod($period) {
        $this->period = $period;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }    

    public function setClass(Classe $class) {
        $this->class = $class;
        return $this;
    }
}