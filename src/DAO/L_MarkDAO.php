<?php

namespace Classy\DAO;

use Classy\Domain\L_Mark;

class L_MarkDAO extends DAO
{

    /**
     * @var \Classy\DAO\StudentDAO
     */
    private $studentDAO;

    public function setStudentDAO(StudentDAO $studentDAO) {
        $this->studentDAO = $studentDAO;
    }


    /**
     * Returns a l_mark matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Clasy\Domain\l_mark|throws an exception if no matching l_mark is found
     */
    public function find($id) {
        $sql = "SELECT * FROM l_mark WHERE l_mark_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mark test matching id " . $id);
    }

    /**
     * Return a array with a list of all l_mark, sorted by id
     *
     * @return array A list of all l_mark.
     */
    public function findAll() {
        $sql = "SELECT * FROM l_mark ORDER BY l_mark_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $l_mark = array();
        foreach ($result as $row) {
            $l_markId = $row['l_mark_id'];
            $l_mark[$l_markId] = $this->buildDomainObject($row);
        }
        return $l_mark;
    }

    /**
     * Return a array with a list of all l_mark associated to a test
     *
     * @return array A list of all l_mark associated to a test
     */
    public function findAllByTest($testId) {
        $sql = "SELECT * FROM l_mark WHERE l_mark_test_id=? ORDER BY l_mark_id";
        $result = $this->getDb()->fetchAll($sql, array($testId));

        // Convert query result to an array of domain objects
        $l_marks = array();
        foreach ($result as $row) {
            $l_markId = $row['l_mark_id'];
            $l_marks[$l_markId] = $this->buildDomainObject($row);
        }
        return $l_marks;
    }

    /**
     * Saves an l_mark into the database.
     *
     * @param \Classy\Domain\l_mark $l_mark The l_mark to save
     */
    public function save($marks) {

        foreach ($marks as $mark) {

            $l_markData = array(
            'l_mark_value' => $mark->getValue(),
            'l_mark_stud_id' => $mark->getStudId(),
            'l_mark_test_id' => $mark->getTestId()        	
            );

            if ($mark->getId()) {
                // The l_mark has already been saved : update it
                $this->getDb()->update('l_mark', $l_markData);
            } else {
                // set the right id in DB
                $this->getDb()->exec('ALTER TABLE l_mark AUTO_INCREMENT = 1');
                // The l_mark has never been saved : insert it
                $this->getDb()->insert('l_mark', $l_markData);
                // Get the id of the newly created l_mark and set it on the entity.
                $id = $this->getDb()->lastInsertId();
                $mark->setId($id);
            }
            
        }
    }



    /**
     * Creates a l_marke object based on a DB row.
     *
     * @param array $row The DB row containing l_mark data.
     * @return \Classy\Domain\l_mark
     */
    protected function buildDomainObject(array $row) {
        $l_mark = new l_mark();
        $l_mark->setId($row['l_mark_id']);
        $l_mark->setValue($row['l_mark_value']);

        if (array_key_exists('l_mark_stud_id', $row)) {
            // Find and set the associated student
            $studId = $row['l_mark_stud_id'];
            $student = $this->studentDAO->find($studId);
            $l_mark->setStudent($student);
        }
        
        return $l_mark;
    }
}


