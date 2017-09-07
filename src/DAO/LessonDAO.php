<?php

namespace Classy\DAO;

use Classy\Domain\Lesson;

class LessonDAO extends DAO
{

    /**
     * @var \Classy\DAO\ChapterDAO
     */
    private $chapterDAO;

    public function setChapterDAO(ChapterDAO $chapterDAO) {
        $this->chapterDAO = $chapterDAO;
    }


    /**
     * Return a array with a list of all lesson, sorted by id
     *
     * @return array A list of all lesson.
     */
    public function findAll() {
        $sql = "SELECT * FROM lesson ORDER BY less_id";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $lesson = array();
        foreach ($result as $row) {
            $lessonId = $row['less_id'];
            $lesson[$lessonId] = $this->buildDomainObject($row);
        }
        return $lesson;
    }

    /**
     * Returns a lesson matching the supplied id.
     *
     * @param integer $id
     *
     * @return \Classy\Domain\lesson|throws an exception if no matching lesson is found
     */
    public function find($id) {
        $sql = "SELECT * FROM lesson WHERE less_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No lesson matching id " . $id);
    }

    /**
     * Return a array with a list of all lesson associated to a chapter
     *
     * @return array A list of all lesson by subject.
     */
    public function findAllByChapter($chapterId) {
        $sql = "SELECT * FROM lesson WHERE less_chap_id=? ORDER BY less_id";
        $result = $this->getDb()->fetchAll($sql, array($chapterId));

        // Convert query result to an array of domain objects
        $lesson = array();
        foreach ($result as $row) {
            $lessonId = $row['less_id'];
            $lesson[$lessonId] = $this->buildDomainObject($row);
        }
        return $lesson;
    }

    /**
     * Return a array with a list of all lesson associated to a class
     *
     * @return array A list of all lesson by class.
     */
    public function findAllByClass($classId) {
        $sql = "SELECT * FROM lesson WHERE less_class_id=? ORDER BY less_id";
        $result = $this->getDb()->fetchAll($sql, array($classId));

        // Convert query result to an array of domain objects
        $lessons = array();
        foreach ($result as $row) {
            $lessonId = $row['less_id'];
            $lessons[$lessonId] = $this->buildDomainObject($row);
        }
        return $lessons;
    }

    /**
     * Saves an lesson into the database.
     *
     * @param \Classy\Domain\lesson $lesson The lesson to save
     */
    public function save(Lesson $lesson) {
        $lessonData = array(
            'less_title' => $lesson->getTitle(),
            'less_situation' => $lesson->getSituation(),
            'less_goal' => $lesson->getGoal(),
            'less_equipment' => $lesson->getEquipment(),
            'less_skill' => $lesson->getSkill(),
            'less_time' => $lesson->getTime(),
            'less_class_id' => $lesson->getChapter()->getSubject()->getClass()->getId(),
            'less_chap_id' => $lesson->getChapter()->getId()            	
            );

        if ($lesson->getId()) {
            // The lesson has already been saved : update it
            $this->getDb()->update('lesson', $lessonData, array('less_id' => $lesson->getId()));
        } else {
            // The lesson has never been saved : insert it
            $this->getDb()->insert('lesson', $lessonData);
            // Get the id of the newly created lesson and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $lesson->setId($id);
        }
    }

    /**
    * Removes a lesson by $id
    *
    * @param integer $id The id of the lesson
    */
    public function delete($id) {
        $this->getDb()->delete('lesson', array('less_id' => $id));
    }

    /**
    * Removes all lessons for a chapter
    *
    * @param $id The id of the chapter
    */
    public function deleteAllByChapter($id) {
        $this->getDb()->delete('lesson', array('less_chap_id' => $id));
    }
        


    /**
     * Creates a lesson object based on a DB row.
     *
     * @param array $row The DB row containing lesson data.
     * @return \Classy\Domain\lesson
     */
    protected function buildDomainObject(array $row) {
        $lesson = new Lesson();
        $lesson->setId($row['less_id']);
        $lesson->setTitle($row['less_title']);
        $lesson->setSituation($row['less_situation']);
        $lesson->setGoal($row['less_goal']);
        $lesson->setEquipment($row['less_equipment']);
        $lesson->setSkill($row['less_skill']);
        $lesson->setTime($row['less_time']);
        $lesson->setClassId($row['less_class_id']);

        if (array_key_exists('less_chap_id', $row)) {
            // Find and set the associated chapter
            $chapterId = $row['less_chap_id'];
            $chapter = $this->chapterDAO->find($chapterId);
            $lesson->setChapter($chapter);
        }
        
        return $lesson;
    }
}

