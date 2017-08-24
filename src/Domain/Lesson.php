<?php

namespace Classy\Domain;

class Lesson 
{
    /**
     * Lesson id.
     *
     * @var integer
     */
    private $id;

    /**
     * Lesson title.
     *
     * @var string
     */
    private $title;

    /**
     * Lesson situation.
     *
     * @var string
     */
    private $situation;

    /**
     * Lesson goal.
     *
     * @var string
     */
    private $goal;

    /**
     * Lesson material.
     *
     * @var string
     */
    private $equipment;

    /**
     * Lesson skill.
     *
     * @var string
     */
    private $skill;

    /**
     * Lesson time.
     *
     * @var integer
     */
    private $time;

    /**
     * Lesson class ID.
     *
     * @var integer
     */
    private $classId;

    /**
     * Associated chapter.
     *
     * @var \Classy\Domain\Chapter
     */
    private $chapter;

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

    public function getSituation() {
        return $this->situation;
    }

    public function setSituation($situation) {
        $this->situation = $situation;
        return $this;
    }

    public function getGoal() {
        return $this->goal;
    }

    public function setGoal($goal) {
        $this->goal = $goal;
        return $this;
    }

    public function getEquipment() {
        return $this->equipment;
    }

    public function setEquipment($equipment) {
        $this->equipment = $equipment;
        return $this;
    }

    public function getSkill() {
        return $this->skill;
    }

    public function setSkill($skill) {
        $this->skill = $skill;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
        return $this;
    }

    public function getClassId() {
        return $this->classId;
    }

    public function setClassId($classId) {
        $this->classId = $classId;
        return $this;
    }

    public function getChapter() {
        return $this->chapter;
    }

    public function setChapter(Chapter $chapter) {
        $this->chapter = $chapter;
        return $this;
    }
}