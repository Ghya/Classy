<?php

namespace Classy\DAO;

use Classy\Domain\Student;

class StudentDAO extends DAO 
{
    /**
     * @var \Classy\DAO\ClasseDAO
     */
    private $classeDAO;

    public function setClassDAO(ClasseDAO $classeDAO) {
        $this->classeDAO = $classeDAO;
    }

    /**
     * Returns a student matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\student|throws an exception if no matching student is found
     */
    public function find($id) {
        $sql = "SELECT * FROM student WHERE stud_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No student matching id " . $id);
    }



    /**
     * Return a list of all students for a class, sorted by id
     *
     * @param integer $classId  class id.
     *
     * @return array A list of all students for the class.
     */
    public function findAllByClass($classId) {
        // The associated class is retrieved only once
        $class = $this->classeDAO->find($classId);

        // class_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "SELECT * FROM student WHERE stud_class_id=? ORDER BY stud_name ASC";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $students = array();
        foreach ($result as $row) {
            $studentId = $row['stud_id'];
            $student = $this->buildDomainObject($row);
            // The associated article is defined for the constructed student
            $student->setClass($class);
            $students[$studentId] = $student;
        }
        return $students;
    }

    

    /**
     * Creates an student object based on a DB row.
     *
     * @param array $row The DB row containing student data.
     * @return \Classy\Domain\Student
     */
    protected function buildDomainObject(array $row) {
        $student = new Student();
        $student->setId($row['stud_id']);
        $student->setFirstName($row['stud_firstname']);
        $student->setName($row['stud_name']);

        if (array_key_exists('stud_class_id', $row)) {
            // Find and set the associated chapter
            $classId = $row['stud_class_id'];
            $class = $this->classeDAO->find($classId);
            $student->setClass($class);
        }

        return $student;
    }
}