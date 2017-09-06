<?php

namespace Classy\DAO;

use Classy\Domain\Subject;

class SubjectDAO extends DAO
{
    /**
     * @var \Classy\DAO\ClasseDAO
     */
    private $classDAO;

    public function setClassDAO(ClasseDAO $classDAO) {
        $this->classDAO = $classDAO;
    }

    /**
     * Return a array with a list of all subject, sorted by id
     *
     * @return array A list of all subject.
     */
    public function findAll() {
        $sql = "SELECT * FROM subject ORDER BY sub_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $subject = array();
        foreach ($result as $row) {
            $subjectId = $row['sub_id'];
            $subject[$subjectId] = $this->buildDomainObject($row);
        }
        return $subject;
    }

    /**
     * Return a array with a list of all subject associated to a classs
     *
     * @return array A list of all subject by class.
     */
    public function findAllByClass($classId) {
        $sql = "SELECT * FROM subject WHERE sub_class_id=? ORDER BY sub_id";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $subject = array();
        foreach ($result as $row) {
            $subjectId = $row['sub_id'];
            $subject[$subjectId] = $this->buildDomainObject($row);
        }
        return $subject;
    }

    /**
     * Returns a subject matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\subject|throws an exception if no matching subject is found
     */
    public function find($id) {
        $sql = "SELECT * FROM subject WHERE sub_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No subject matching id " . $id);
    }

    /**
     * Saves an subject into the database.
     *
     * @param \Classy\Domain\subject $subject The subject to save
     */
    public function save(Subject $subject) {
        $subjectData = array(
            'sub_name' => $subject->getName(),
            'sub_class_id' => $subject->getClass()->getId()
            );

        if ($subject->getId()) {
            // The subject has already been saved : update it
            $this->getDb()->update('subject', $subjectData, array('sub_id' => $subject->getId()));
        } else {
            // The subject has never been saved : insert it
            $this->getDb()->insert('subject', $subjectData);
            // Get the id of the newly created subject and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $subject->setId($id);
        }
    }

    /**
    * Removes a subject by $id
    *
    * @param integer $id The id of the subject
    */
    public function delete($id) {
        $this->getDb()->delete('subject', array('sub_id' => $id));
    }


    /**
     * Creates a subjecte object based on a DB row.
     *
     * @param array $row The DB row containing subjecte data.
     * @return \Classy\Domain\subject
     */
    protected function buildDomainObject(array $row) {
        $subject = new Subject();
        $subject->setId($row['sub_id']);
        $subject->setName($row['sub_name']);

        if (array_key_exists('sub_class_id', $row)) {
            // Find and set the associated class
            $classId = $row['sub_class_id'];
            $class = $this->classDAO->find($classId);
            $subject->setClass($class);
        }
        
        return $subject;
    }
}


