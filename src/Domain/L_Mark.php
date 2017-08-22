<?php

namespace Classy\Domain;

class L_Mark 
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
    private $value;

    /**
     * Mark Student
     *
     * @var Classy/Domain/Student
     */
    private $student;    

    /**
     * Test table marks Id
     *
     * @var int
     */
    private $testId;

    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getTestId() {
        return $this->testId;
    }

    public function setTestId($testId) {
        $this->testId = $testId;
        return $this;
    }

    public function getStudent() {
        return $this->student;
    }

    public function setStudent(Student $student) {
        $this->student = $student;
        return $this;
    }
}