<?php

namespace Classy\DAO;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\L_Test;

class L_TestDAO extends DAO
{

    /**
     * @var \Classy\DAO\LessonDAO
     */
    private $lessonDAO;

    public function setLessonDAO(LessonDAO $lessonDAO) {
        $this->lessonDAO = $lessonDAO;
    }

    /**
     * Return a array with a list of all l_test, sorted by id
     *
     * @return array A list of all l_test.
     */
    public function findAll() {
        $sql = "SELECT * FROM l_test ORDER BY l_test_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $l_test = array();
        foreach ($result as $row) {
            $l_testId = $row['l_test_id'];
            $l_test[$l_testId] = $this->buildDomainObject($row);
        }
        return $l_test;
    }

    /**
     * Count number of test by class
     *
     * @return int nbr of test
     */
     public function count($idClass) {
        $sql = "SELECT COUNT(l_test_id) FROM l_test WHERE l_test_class_id=?";
        $result = $this->getDb()->fetchArray($sql, array($idClass));
        
        return $result[0];
    }

    /**
     * Average by class
     *
     * @return int average
     */
     public function avg($idClass) {
        $sql = "SELECT AVG(l_test_avg) FROM l_test WHERE l_test_class_id=?";
        $result = $this->getDb()->fetchArray($sql, array($idClass));
        
        return $result[0];
    }

    /**
     * Returns a l_test matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Clasy\Domain\l_test|throws an exception if no matching l_test is found
     */
    public function find($id) {
        $sql = "SELECT * FROM l_test WHERE l_test_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No l_test test matching id " . $id);
    }

    /**
     * Return a array with a list of all l_test associated to a lesson
     *
     * @return array A list of all l_test by lesson.
     */
    public function findAllByLesson($lessId) {
        $sql = "SELECT * FROM l_test WHERE l_test_less_id=? ORDER BY l_test_id";
        $result = $this->getDb()->fetchAll($sql, array($lessId));

        // Convert query result to an array of domain objects
        $l_tests = array();
        foreach ($result as $row) {
            $l_testId = $row['l_test_id'];
            $l_tests[$l_testId] = $this->buildDomainObject($row);
        }
        return $l_tests;
    }

    /**
     * Return a array with a list of all l_test associated to a class
     *
     * @return array A list of all l_test by class.
     */
    public function findAllByClass($classId) {
        $sql = "SELECT l_test_id, l_test_name, l_test_class_id, l_test_less_id, DATE_FORMAT(l_test_date, '%d/%m/%Y') AS l_test_date, l_test_avg, l_class_avg
                FROM l_test 
                WHERE l_test_class_id=? 
                ORDER BY l_test_date";

                $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $l_tests = array();
        foreach ($result as $row) {
            $l_testId = $row['l_test_id'];
            $l_tests[$l_testId] = $this->buildDomainObject($row);
        }
        return $l_tests;
    }
    
    /**
        * Return the date of the test
        *
        * @return string the date
        */
        public function avgDateTest($classId) {
        $sql = "SELECT l_test_id, l_test_name, l_test_class_id, l_test_less_id, DATE_FORMAT(l_test_date, '%d/%m/%Y') AS testdate, l_test_avg, l_class_avg
                FROM l_test
                WHERE l_test_class_id=? 
                ORDER BY l_test_date";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $l_tests = array();
        foreach ($result as $row) {
            $l_testId = $row['l_test_id'];
            $l_tests[$l_testId] = $this->buildDomainObject2($row);
        }
        return $l_tests;
    }

    /**
     * Calculate test average
     *
     * @param 
     */
     public function average($marks) {
        $marksSum = 0;
        $markNb = 0;
        foreach($marks as $mark)
        {
            $marksSum += $mark->getValue();
            $markNb ++;
        }
        $average = $marksSum/$markNb;
        
        return $average;
     }

     /**
     * Sum test class after the test
     *
     * @param 
     */
     public function sumClassTest($classId, $date) {

        $sql = "SELECT SUM(l_test_avg) AS somme
                FROM l_test
                WHERE l_test_class_id=?
                AND l_test_date <=?";
            
        $result = $this->getDb()->fetchArray($sql, array($classId, $date));
        
        return $result[0];
     }

     /**
     * Number of test with this one
     *
     * @param 
     */
     public function numClassTest($classId, $date) {
        
        $sql = "SELECT l_test_id
                FROM l_test
                WHERE l_test_class_id=?
                AND l_test_date <=?";

        $result = $this->getDb()->fetchAll($sql, array($classId, $date));
        
        $nbr = count($result);
        return $nbr;
        }

    /**
     * Saves an l_test and l_mark associated into the database.
     *
     * @param \Classy\Domain\l_test $l_test The l_test to save with associated marks
     */
    public function saveTestMarks(L_Test $l_test, $marks) {
        $l_testData = array(
                'l_test_name' => $l_test->getName(),
                'l_test_less_id' => $l_test->getLesson()->getId(),
                'l_test_class_id' => $l_test->getLesson()->getChapter()->getSubject()->getClass()->getId(),
                'l_test_date' => $l_test->getDate(),
                'l_test_avg' => $this->average($marks),
                'l_class_avg' => ( $this->sumClassTest($l_test->getClassId(), $l_test->getDate()) ) / ( $this->numClassTest($l_test->getClassId(), $l_test->getDate()) )
            );

        if ($l_test->getId()) {
            // The l_test has already been saved : update it
            $this->getDb()->update('l_test', $l_testData, array('l_test_id' => $l_test->getId()));

            foreach ($marks as $mark) {
                $mark->setTestId($l_test->getId());

                $l_markData = array(
                'l_mark_value' => $mark->getValue(),
                'l_mark_stud_id' => $mark->getStudent()->getId(),
                'l_mark_test_id' => $mark->getTestId()        	
                );

                if ($mark->getId()) {
                    // The l_mark has already been saved : update it
                    $this->getDb()->update('l_mark', $l_markData, array('l_mark_id' => $mark->getId()));
                } else {
                    // The l_mark has never been saved : insert it
                    $this->getDb()->insert('l_mark', $l_markData);
                    // Get the id of the newly created l_mark and set it on the entity.
                    $id = $this->getDb()->lastInsertId();
                    $mark->setId($id);
                }
            }

        } else {
            // The l_test has never been saved : insert it
            $this->getDb()->insert('l_test', $l_testData);
            // Get the id of the newly created l_test and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $l_test->setId($id);

            foreach ($marks as $mark) {
                $mark->setTestId($l_test->getId());

                $l_markData = array(
                'l_mark_value' => $mark->getValue(),
                'l_mark_stud_id' => $mark->getStudent()->getId(),
                'l_mark_test_id' => $mark->getTestId()        	
                );

                if ($mark->getId()) {
                    // The l_mark has already been saved : update it
                    $this->getDb()->update('l_mark', $l_markData, array('l_mark_id' => $mark->getId()));
                } else {
                    // The l_mark has never been saved : insert it
                    $this->getDb()->insert('l_mark', $l_markData);
                    // Get the id of the newly created l_mark and set it on the entity.
                    $id = $this->getDb()->lastInsertId();
                    $mark->setId($id);
                }
            }
        }
    }

    /**
    * Removes a l_test by $id
    *
    * @param integer $id The id of the l_test
    */
    public function delete($id) {
        $this->getDb()->delete('l_test', array('l_test_id' => $id));
    }

    /**
    * Removes all l_test for a lessons
    *
    * @param $id The id of the lessons
    */
    public function deleteAllByLesson($id) {
        $this->getDb()->delete('l_test', array('l_test_less_id' => $id));
    }

    /**
     * Creates a l_teste object based on a DB row.
     *
     * @param array $row The DB row containing l_test data.
     * @return \Classy\Domain\l_test
     */
     protected function buildDomainObject(array $row) {
        $l_test = new L_Test();
        $l_test->setId($row['l_test_id']);
        $l_test->setName($row['l_test_name']);
        $l_test->setClassId($row['l_test_class_id']);
        $l_test->setAverage($row['l_test_avg']);
        $l_test->setDate($row['l_test_date']);
        $l_test->setClassAvg($row['l_class_avg']);

        if (array_key_exists('l_test_less_id', $row)) {
            // Find and set the associated subject
            $lessonId = $row['l_test_less_id'];
            $lesson = $this->lessonDAO->find($lessonId);
            $l_test->setLesson($lesson);
        }
        
        return $l_test;
    }


    /**
     * Creates a l_teste object based on a DB row.
     *
     * @param array $row The DB row containing l_test data.
     * @return \Classy\Domain\l_test
     */
    protected function buildDomainObject2(array $row) {
        $l_test = new L_Test();
        $l_test->setId($row['l_test_id']);
        $l_test->setName($row['l_test_name']);
        $l_test->setClassId($row['l_test_class_id']);
        $l_test->setAverage($row['l_test_avg']);
        $l_test->setDate($row['testdate']);
        $l_test->setClassAvg($row['l_class_avg']);

        if (array_key_exists('l_test_less_id', $row)) {
            // Find and set the associated subject
            $lessonId = $row['l_test_less_id'];
            $lesson = $this->lessonDAO->find($lessonId);
            $l_test->setLesson($lesson);
        }
        
        return $l_test;
    }
    
}


