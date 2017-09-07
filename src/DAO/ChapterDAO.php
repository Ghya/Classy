<?php

namespace Classy\DAO;

use Classy\Domain\Chapter;

class ChapterDAO extends DAO
{

    /**
     * @var \Classy\DAO\SubjectDAO
     */
    private $subjectDAO;

    public function setSubjectDAO(SubjectDAO $subjectDAO) {
        $this->subjectDAO = $subjectDAO;
    }



    /**
     * Return a array with a list of all chapter, sorted by id
     *
     * @return array A list of all chapter.
     */
    public function findAll() {
        $sql = "SELECT * FROM chapter ORDER BY chap_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $chapter = array();
        foreach ($result as $row) {
            $chapterId = $row['chap_id'];
            $chapter[$chapterId] = $this->buildDomainObject($row);
        }
        return $chapter;
    }

    /**
     * Returns a chapter matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\chapter|throws an exception if no matching chapter is found
     */
    public function find($id) {
        $sql = "SELECT * FROM chapter WHERE chap_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No chapter matching id " . $id);
    }

    /**
     * Return a array with a list of all chapter associated to a subject
     *
     * @return array A list of all chapter by subject.
     */
    public function findAllBySubject($subjectId) {
        $sql = "SELECT * FROM chapter WHERE chap_sub_id=? ORDER BY chap_id";
        $result = $this->getDb()->fetchAll($sql, array($subjectId));

        // Convert query result to an array of domain objects
        $chapter = array();
        foreach ($result as $row) {
            $chapterId = $row['chap_id'];
            $chapter[$chapterId] = $this->buildDomainObject($row);
        }
        return $chapter;
    }

    /**
     * Return a array with a list of all chapter associated to a class
     *
     * @return array A list of all chapter by class.
     */
    public function findAllByClass($classId) {
        $sql = "SELECT * FROM chapter WHERE chap_class_id=? ORDER BY chap_id";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $chapter = array();
        foreach ($result as $row) {
            $chapterId = $row['chap_id'];
            $chapter[$chapterId] = $this->buildDomainObject($row);
        }
        return $chapter;
    }

    /**
     * Saves an chapter into the database.
     *
     * @param \Classy\Domain\chapter $chapter The chapter to save
     */
    public function save(Chapter $chapter) {
        $chapterData = array(
            'chap_name' => $chapter->getName(),
            'chap_sub_id' => $chapter->getSubject()->getId(),
            'chap_class_id' => $chapter->getSubject()->getClass()->getId()             	
            );

        if ($chapter->getId()) {
            // The chapter has already been saved : update it
            $this->getDb()->update('chapter', $chapterData, array('chap_id' => $chapter->getId()));
        } else {
            // The chapter has never been saved : insert it
            $this->getDb()->insert('chapter', $chapterData);
            // Get the id of the newly created chapter and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $chapter->setId($id);
        }
    }

    /**
    * Removes a chapter by $id
    *
    * @param integer $id The id of the chapter
    */
    public function delete($id) {
        $this->getDb()->delete('chapter', array('chap_id' => $id));
    }

    /**
     * Removes all chapters for a subject
     *
     * @param $id The id of the subject
     */
     public function deleteAllBySubject($id) {
        $this->getDb()->delete('chapter', array('chap_sub_id' => $id));
    }


    /**
     * Creates a chapter object based on a DB row.
     *
     * @param array $row The DB row containing chapter data.
     * @return \chaptery\Domain\chapter
     */
    protected function buildDomainObject(array $row) {
        $chapter = new Chapter();
        $chapter->setId($row['chap_id']);
        $chapter->setName($row['chap_name']);
        $chapter->setClassId($row['chap_class_id']);

        if (array_key_exists('chap_sub_id', $row)) {
            // Find and set the associated subject
            $subjectId = $row['chap_sub_id'];
            $subject = $this->subjectDAO->find($subjectId);
            $chapter->setSubject($subject);
        }
        
        return $chapter;
    }
}

