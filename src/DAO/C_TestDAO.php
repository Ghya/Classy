<?php

namespace Classy\DAO;

use Classy\Domain\C_Test;

class C_TestDAO extends DAO
{

    /**
     * Return a array with a list of all c_test, sorted by id
     *
     * @return array A list of all c_test.
     */
    public function findAll() {
        $sql = "SELECT * FROM c_test ORDER BY c_test_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $c_test = array();
        foreach ($result as $row) {
            $c_testId = $row['c_test_id'];
            $c_test[$c_testId] = $this->buildDomainObject($row);
        }
        return $c_test;
    }

    /**
     * Returns a c_test matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Clasy\Domain\c_test|throws an exception if no matching c_test is found
     */
    public function find($id) {
        $sql = "SELECT * FROM c_test WHERE c_test_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No chapter test matching id " . $id);
    }


    /**
     * Creates a c_teste object based on a DB row.
     *
     * @param array $row The DB row containing c_test data.
     * @return \Classy\Domain\c_test
     */
    protected function buildDomainObject(array $row) {
        $c_test = new C_Test();
        $c_test->setId($row['c_test_id']);
        $c_test->setName($row['c_test_name']);
        $c_test->setChapId($row['c_test_chap_id']);
        $c_test->setMarkId($row['c_test_mark_id']);
        
        return $c_test;
    }
}


