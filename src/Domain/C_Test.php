<?php

namespace Classy\Domain;

class C_Test 
{
    /**
     * Test id.
     *
     * @var integer
     */
    private $id;

    /**
     * Test name
     *
     * @var string
     */
    private $name;

    /**
     * Test chap Id
     *
     * @var int
     */
    private $chapId;

    /**
     * Test table marks Id
     *
     * @var int
     */
    private $markId;

    

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

    public function getChapId() {
        return $this->chapId;
    }

    public function setChapId($chapId) {
        $this->chapId = $chapId;
        return $this;
    }

    public function getMarkId() {
        return $this->markId;
    }

    public function setMarkId($markId) {
        $this->markId = $markId;
        return $this;
    }
}