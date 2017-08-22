<?php

namespace Classy\Domain;

use Doctrine\Common\Collections\ArrayCollection;

class L_Test 
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
     * Test lesson
     *
     * @var Classy/Domain/Lesson
     */
    private $lesson;

    /**
     * Test class id
     *
     * @var Classy/Domain/Lesson
     */
    private $classId;

    /**
     * array of marks
     *
     * @var Classy/Domain/L_Mark
     */
    private $marks;

    public function __construct()
    {
        $this->marks = new ArrayCollection();
    }

    public function getMarks()
    {
        return $this->marks;
    }

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

    public function getLesson() {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson) {
        $this->lesson = $lesson;
        return $this;
    }
}