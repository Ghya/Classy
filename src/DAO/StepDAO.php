<?php

namespace Classy\DAO;

use Classy\Domain\Step;

class StepDAO extends DAO
{

    /**
     * @var \Classy\DAO\stepDAO
     */
    private $lessonDAO;

    public function setLessonDAO(LessonDAO $lessonDAO) {
        $this->lessonDAO = $lessonDAO;
    }



    /**
     * Return a array with a list of all step, sorted by id
     *
     * @return array A list of all step.
     */
    public function findAll() {
        $sql = "SELECT * FROM step ORDER BY step_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $step = array();
        foreach ($result as $row) {
            $stepId = $row['step_id'];
            $step[$stepId] = $this->buildDomainObject($row);
        }
        return $step;
    }

    /**
     * Returns a step matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\step|throws an exception if no matching step is found
     */
    public function find($id) {
        $sql = "SELECT * FROM step WHERE step_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No step matching id " . $id);
    }

    /**
     * Return a array with a list of all step associated to a subject
     *
     * @return array A list of all step by subject.
     */
    public function findAllByLessonDesc($lessonId) {
        $sql = "SELECT * FROM step WHERE step_less_id=? ORDER BY step_id DESC";
        $result = $this->getDb()->fetchAll($sql, array($lessonId));

        // Convert query result to an array of domain objects
        $step = array();
        foreach ($result as $row) {
            $stepId = $row['step_id'];
            $step[$stepId] = $this->buildDomainObject($row);
        }
        return $step;
    }

    /**
     * Return a array with a list of all step associated to a subject
     *
     * @return array A list of all step by subject.
     */
    public function findAllByLesson($lessonId) {
        $sql = "SELECT * FROM step WHERE step_less_id=? ORDER BY step_id";
        $result = $this->getDb()->fetchAll($sql, array($lessonId));

        // Convert query result to an array of domain objects
        $step = array();
        foreach ($result as $row) {
            $stepId = $row['step_id'];
            $step[$stepId] = $this->buildDomainObject($row);
        }
        return $step;
    }

    /**
     * Saves a step into the database.
     *
     * @param \Classy\Domain\step $step The step to save
     */
    public function save(Step $step) {
        $stepData = array(
            'step_name' => $step->getName(),
            'step_content' => $step->getContent(),
            'step_time' => $step->getTime(),
            'step_less_id' => $step->getLesson()->getId()             	
            );

        if ($step->getId()) {
            // The step has already been saved : update it
            $this->getDb()->update('step', $stepData);
        } else {
            // The step has never been saved : insert it
            $this->getDb()->insert('step', $stepData);
            // Get the id of the newly created step and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $step->setId($id);
        }
    }

    /**
     * Removes a step from the database.
     *
     * @param @param integer $id The step id
     */
     public function delete($id) {
        // Delete the step
        $this->getDb()->delete('step', array('step_id' => $id));
    }

    /**
     * Removes all steps for a lesson
     *
     * @param integer $id The id of the lesson
     */
    public function deleteAllByLesson($id) {
        $this->getDb()->delete('step', array('step_less_id' => $id));
    }


    /**
     * Creates a step object based on a DB row.
     *
     * @param array $row The DB row containing step data.
     * @return \stepy\Domain\step
     */
    protected function buildDomainObject(array $row) {
        $step = new step();
        $step->setId($row['step_id']);
        $step->setName($row['step_name']);
        $step->setContent($row['step_content']);
        $step->setTime($row['step_time']);

        if (array_key_exists('step_less_id', $row)) {
            // Find and set the associated subject
            $lessonId = $row['step_less_id'];
            $lesson = $this->lessonDAO->find($lessonId);
            $step->setLesson($lesson);
        }
        
        return $step;
    }
}

