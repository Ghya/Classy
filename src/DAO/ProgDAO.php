<?php

namespace Classy\DAO;

use Classy\Domain\Prog;

class ProgDAO extends DAO
{
    /**
     * @var \Classy\DAO\ClasseDAO
     */
    private $classDAO;

    public function setClassDAO(ClasseDAO $classDAO) {
        $this->classDAO = $classDAO;
    }

    /**
     * @var \Classy\DAO\ClasseDAO
     */
    private $subjectDAO;

    public function setSubjectDAO(SubjectDAO $subjectDAO) {
        $this->subjectDAO = $subjectDAO;
    }

    /**
     * Return a array with a list of all prog, sorted by id
     *
     * @return array A list of all prog.
     */
    public function findAll() {
        $sql = "SELECT * FROM prog ORDER BY prog_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $prog = array();
        foreach ($result as $row) {
            $progId = $row['prog_id'];
            $prog[$progId] = $this->buildDomainObject($row);
        }
        return $prog;
    }

    /**
     * Return a array with a list of all prog associated to a classs
     *
     * @return array A list of all prog by class.
     */
    public function findAllByClassAndPeriod($classId, $periodID) {
        $sql = "SELECT * FROM programm WHERE prog_class_id=? AND prog_period=?";
        $result = $this->getDb()->fetchAll($sql, array($classId, $periodID));

        // Convert query result to an array of domain objects
        $prog = array();
        foreach ($result as $row) {
            $progId = $row['prog_id'];
            $prog[$progId] = $this->buildDomainObject($row);
        }
        return $prog;
    }

    /**
     * Returns a prog matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\prog|throws an exception if no matching prog is found
     */
    public function find($id) {
        $sql = "SELECT * FROM prog WHERE prog_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No prog matching id " . $id);
    }

    /**
     * Saves an prog into the database.
     *
     * @param \Classy\Domain\prog $prog The prog to save
     */
    public function save(prog $prog) {
        $progData = array(
            'prog_sub_id' => $prog->getSubject()->getId(),
            'prog_class_id' => $prog->getClass()->getId(),
            'prog_content' => $prog->getContent(),
            'prog_period' => $prog->getPeriod()
            );

        if ($prog->getId()) {
            // The prog has already been saved : update it
            $this->getDb()->update('prog', $progData);
        } else {
            // The prog has never been saved : insert it
            $this->getDb()->insert('prog', $progData);
            // Get the id of the newly created prog and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $prog->setId($id);
        }
    }

    /**
    * Removes a prog by $id
    *
    * @param integer $id The id of the prog
    */
    public function delete($id) {
        $this->getDb()->delete('prog', array('prog_id' => $id));
    }


    /**
     * Creates a proge object based on a DB row.
     *
     * @param array $row The DB row containing proge data.
     * @return \Classy\Domain\prog
     */
    protected function buildDomainObject(array $row) {
        $prog = new Prog();
        $prog->setId($row['prog_id']);
        $prog->setContent($row['prog_content']);
        $prog->setPeriod($row['prog_period']);

        if (array_key_exists('prog_class_id', $row)) {
            // Find and set the associated class
            $classId = $row['prog_class_id'];
            $class = $this->classDAO->find($classId);
            $prog->setClass($class);
        }

        if (array_key_exists('prog_sub_id', $row)) {
            // Find and set the associated subject
            $subjectId = $row['prog_sub_id'];
            $subject = $this->subjectDAO->find($subjectId);
            $prog->setSubject($subject);
        }
        
        return $prog;
    }
}


