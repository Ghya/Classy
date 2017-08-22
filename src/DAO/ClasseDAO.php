<?php

namespace Classy\DAO;

use Classy\Domain\Classe;

class ClasseDAO extends DAO
{

    /**
     * Return a array with a list of all class, sorted by id
     *
     * @return array A list of all class.
     */
    public function findAll() {
        $sql = "SELECT * FROM class ORDER BY class_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $class = array();
        foreach ($result as $row) {
            $classId = $row['class_id'];
            $class[$classId] = $this->buildDomainObject($row);
        }
        return $class;
    }

    /**
     * Returns a class matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\class|throws an exception if no matching class is found
     */
    public function find($id) {
        $sql = "SELECT * FROM class WHERE class_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No class matching id " . $id);
    }

    /**
     * Saves an class into the database.
     *
     * @param \Classy\Domain\class $class The class to save
     */
    public function save(Classe $class) {
        $classData = array(
            'class_lvl' => $class->getLvl(),
            'class_etab' => $class->getEtab()           	
            );

        if ($class->getId()) {
            // The class has already been saved : update it
            $this->getDb()->update('class', $classData);
        } else {
            // The class has never been saved : insert it
            $this->getDb()->insert('class', $classData);
            // Get the id of the newly created class and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $class->setId($id);
        }
    }


    /**
     * Creates a Classe object based on a DB row.
     *
     * @param array $row The DB row containing classe data.
     * @return \Classy\Domain\Classe
     */
    protected function buildDomainObject(array $row) {
        $class = new Classe();
        $class->setId($row['class_id']);
        $class->setLvl($row['class_lvl']);
        $class->setEtab($row['class_etab']);
        
        return $class;
    }
}


