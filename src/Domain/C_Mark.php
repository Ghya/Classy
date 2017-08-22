<?php

namespace Classy\Domain;

class C_Mark 
{
    /**
     * Mark id.
     *
     * @var integer
     */
    private $id;

    /**
     * Mark name
     *
     * @var string
     */
    private $name;

    /**
     * Mark Student Id
     *
     * @var string
     */
    private $studId;

    

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

    public function getStudId() {
        return $this->studId;
    }

    public function setStudId($studId) {
        $this->studId = $studId;
        return $this;
    }
}