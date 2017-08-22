<?php

namespace Classy\Domain;

class Chapter 
{
    /**
     * chapter id.
     *
     * @var integer
     */
    private $id;

    /**
     * chapter name.
     *
     * @var integer
     */
    private $name;

    /**
     * chapter name.
     *
     * @var integer
     */
    private $classId;

    /**
     * Associated subject.
     *
     * @var \Classy\Domain\Chapter
     */
    private $subject;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getClassId() {
        return $this->classId;
    }

    public function setClassId($classId) {
        $this->classId = $classId;
        return $this;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject(Subject $subject) {
        $this->subject = $subject;
        return $this;
    }
}