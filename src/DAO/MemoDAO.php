<?php

namespace Classy\DAO;

use Classy\Domain\memo;

class MemoDAO extends DAO
{
    /**
     * Returns a memo matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\memo|throws an exception if no matching memo is found
     */
    public function find($id) {
        $sql = "SELECT * FROM memo WHERE memo_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No memo matching id " . $id);
    }

    /**
     * Returns last memo post.
     *
     * @return object last memo
     */
    public function findLast() {
        $sql = "SELECT * FROM memo ORDER BY memo_id DESC LIMIT 0,1";
        $row = $this->getDb()->fetchAssoc($sql);

        if ($row)
            return $this->buildDomainObject($row);
        else
            return false;
    }


    /**
     * Return a array with a list of all memo, sorted by date (most recent first).
     *
     * @return array A list of all memo.
     */
    public function findAll() {
        $sql = "SELECT * FROM memo ORDER BY memo_date DESC";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $memos = array();

        if ($result) {
            foreach ($result as $row) {
                $memoId = $row['memo_id'];
                $memos[$memoId] = $this->buildDomainObject($row);
            }
            return $memos;
        }
            
        else
            return false;
        
    }

    /**
     * Saves an memo into the database.
     *
     * @param \Classy\Domain\Memo $memo The memo to save
     */
    public function save(Memo $memo) {
        $memoData = array(
            'memo_title' => $memo->getTitle(),
            'memo_content' => $memo->getContent(),
            'memo_date' => $memo->getNowDate(),
            );

        if ($memo->getId()) {
            // The memo has already been saved : update it
            $this->getDb()->update('memo', $memoData);
        } else {
            // The memo has never been saved : insert it
            $this->getDb()->insert('memo', $memoData);
            // Get the id of the newly created memo and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $memo->setId($id);
        }
    }

    /**
     * Removes an memo from the database.
     *
     * @param integer $id The memo id.
     */
    public function delete($id) {
        // Delete the memo
        $this->getDb()->delete('memo', array('memo_id' => $id));
        // Avoid auto increment fail
        $this->getDb()->exec('ALTER TABLE memo AUTO_INCREMENT = 1');
    }


    /**
     * Creates a memo object based on a DB row.
     *
     * @param array $row The DB row containing memo data.
     * @return \ProjetPHP\Domain\memo
     */
    protected function buildDomainObject(array $row) {
        $memo = new Memo();
        $memo->setId($row['memo_id']);
        $memo->setTitle($row['memo_title']);
        $memo->setContent($row['memo_content']);
        $memo->setDate($row['memo_date']);
        return $memo;
    }
}


