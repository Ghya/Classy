<?php

namespace Classy\Domain;

class Student 
{
    /**
     * student id.
     *
     * @var integer
     */
    private $id;

    /**
     * student fistname.
     *
     * @var string
     */
    private $firstname;

    /**
     * student name.
     *
     * @var integer
     */
    private $name;

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

    public function getFirstName() {
        return $this->firstname;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
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