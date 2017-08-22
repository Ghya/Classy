<?php

namespace Classy\Domain;

class Step 
{
    /**
     * step id.
     *
     * @var integer
     */
    private $id;

    /**
     * step name.
     *
     * @var integer
     */
    private $name;

    /**
     * step content.
     *
     * @var integer
     */
    private $content;

    /**
     * step time.
     *
     * @var integer
     */
    private $time;

    /**
     * Associated lesson.
     *
     * @var \Classy\Domain\Lesson
     */
    private $lesson;

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

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
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