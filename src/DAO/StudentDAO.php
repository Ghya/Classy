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
     * Saves an student into the database.
     *
     * @param \Classy\Domain\student $student The student to save
     */
    public function save(Student $student) {
        $studentData = array(
                'stud_gender' => $student->getGender(),
                'stud_name' => $student->getName(),
                'stud_firstname' => $student->getFirstName(),
                'stud_class_id' => $student->getClass()->getId(),
                'stud_birth_date' => $student->getBirth(),
                'stud_mom_name' => $student->getMomName(),
                'stud_dad_name' => $student->getDadName(),
                'stud_parent_tel' => $student->getTel(),
                'stud_parent_adress' => $student->getAdress(),
                'stud_parent_CP' => $student->getCP(),
                'stud_parent_city' => $student->getCity(),
                'stud_prev_etab' => $student->getPrevEtab(),
                'stud_parent_city' => $student->getCity(),
                'stud_PPRE' => $student->getPPRE(),
                'stud_RASED' => $student->getRASED(),
                'stud_PAI' => $student->getPAI(),
                'stud_APC' => $student->getAPC(),
                'stud_PPRE_note' => $student->getPPRENote(),
                'stud_RASED_note' => $student->getRASEDNote(),
                'stud_PAI_note' => $student->getPAINote(),
                'stud_APC_note' => $student->getAPCNote(),
                'stud_coop' => $student->getCoop(),
                'stud_coll' => $student->getColl(),
                'stud_note' => $student->getNote(),
            );

        if ($student->getId()) {
            // The student has already been saved : update it
            $this->getDb()->update('student', $studentData, array('stud_id' => $student->getId()));
        } else {
            // The student has never been saved : insert it
            $this->getDb()->insert('student', $studentData);
            // Get the id of the newly created student and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $student->setId($id);
        }
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
        $student->setGender($row['stud_gender']);
        $student->setFirstName($row['stud_firstname']);
        $student->setName($row['stud_name']);
        $student->setBirth($row['stud_birth_date']);
        $student->setMomName($row['stud_mom_name']);
        $student->setDadName($row['stud_dad_name']);
        $student->setTel($row['stud_parent_tel']);
        $student->setAdress($row['stud_parent_adress']);
        $student->setCP($row['stud_parent_CP']);
        $student->setCity($row['stud_parent_city']);
        $student->setPrevEtab($row['stud_prev_etab']);
        $student->setCity($row['stud_parent_city']);
        $student->setPPRE($row['stud_PPRE']);
        $student->setRASED($row['stud_RASED']);
        $student->setPAI($row['stud_PAI']);
        $student->setAPC($row['stud_APC']);
        $student->setPPRENote($row['stud_PPRE_note']);
        $student->setRASEDNote($row['stud_RASED_note']);
        $student->setPAINote($row['stud_PAI_note']);
        $student->setAPCNote($row['stud_APC_note']);
        $student->setCoop($row['stud_coop']);
        $student->setColl($row['stud_coll']);
        $student->setNote($row['stud_note']);
        

        if (array_key_exists('stud_class_id', $row)) {
            // Find and set the associated chapter
            $classId = $row['stud_class_id'];
            $class = $this->classeDAO->find($classId);
            $student->setClass($class);
        }

        return $student;
    }

    /**
     * Return a list with name firstname and class of student matching the supplied classs id
     *
     * @param integer $classId  class id.
     *
     * @return array A list of all students for the class.
     */
    public function findAllByClassSimple($classId) {
        // The associated class is retrieved only once
        $class = $this->classeDAO->find($classId);

        // class_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "SELECT stud_id, stud_name, stud_firstname, stud_class_id FROM student WHERE stud_class_id=? ORDER BY stud_name ASC";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $students = array();
        foreach ($result as $row) {
            $studentId = $row['stud_id'];
            $student = $this->buildSimpleDomainObject($row);
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
    protected function buildSimpleDomainObject(array $row) {
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