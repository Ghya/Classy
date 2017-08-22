<?php

namespace Classy\DAO;

use Classy\Domain\C_Mark;

class C_MarkDAO extends DAO
{

    /**
     * Return a array with a list of all c_mark, sorted by id
     *
     * @return array A list of all c_mark.
     */
    public function findAll() {
        $sql = "SELECT * FROM c_mark ORDER BY c_mark_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $c_mark = array();
        foreach ($result as $row) {
            $c_markId = $row['c_mark_id'];
            $c_mark[$c_markId] = $this->buildDomainObject($row);
        }
        return $c_mark;
    }

    /**
     * Returns a c_mark matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Clasy\Domain\c_mark|throws an exception if no matching c_mark is found
     */
    public function find($id) {
        $sql = "SELECT * FROM c_mark WHERE c_mark_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mark test matching id " . $id);
    }


    /**
     * Creates a c_marke object based on a DB row.
     *
     * @param array $row The DB row containing c_mark data.
     * @return \Classy\Domain\c_mark
     */
    protected function buildDomainObject(array $row) {
        $c_mark = new c_mark();
        $c_mark->setId($row['c_mark_id']);
        $c_mark->setValue($row['c_mark_value']);
        $c_mark->setStudId($row['c_mark_stud_id']);
        
        return $c_mark;
    }
}


