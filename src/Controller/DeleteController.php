<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class DeleteController {

    /**
    * Delete subject controller.
    *
    * @param integer $id chapter id
    * @param Application $app Silex application
    */
    public function deleteSubjectAction($idClass, $idSub, Application $app) {

        $class = $app['dao.class']->find($idClass);
        
        $chapters = $app['dao.chapter']->findAllBySubject($idSub);

        foreach ($chapters as $chapter) {
            $lessons = $app['dao.lesson']->findAllByChapter($chapter->getId());

                foreach ($lessons as $lesson) {
                    $steps = $app['dao.step']->deleteAllByLesson($lesson->getId());
                    $l_tests = $app['dao.l_test']->findAllByLesson($lesson->getId());

                        foreach ($l_tests as $l_test) {
                            $l_marks = $app['dao.l_mark']->deleteAllByTest($l_test->getId());
                        }
                    
                    $app['dao.l_test']->deleteAllByLesson($lesson->getId());
                }

            $app['dao.lesson']->deleteAllByChapter($chapter->getId());
            
        }

        $app['dao.chapter']->deleteAllBySubject($idSub);
        $app['dao.subject']->delete($idSub);

        return $app->redirect($app['url_generator']->generate('sub_manag', [
            "id" => $class->getId()
        ]));
    }

    /**
    * Delete chapter controller.
    *
    * @param integer $id chapter id
    * @param Application $app Silex application
    */
    public function deleteChapterAction($idClass, $idChap, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        
        $lessons = $app['dao.lesson']->findAllByChapter($idChap);


        foreach ($lessons as $lesson) {
            $steps = $app['dao.step']->deleteAllByLesson($lesson->getId());
            $l_tests = $app['dao.l_test']->findAllByLesson($lesson->getId());

                foreach ($l_tests as $l_test) {
                    $l_marks = $app['dao.l_mark']->deleteAllByTest($l_test->getId());
                }
            
            $app['dao.l_test']->deleteAllByLesson($lesson->getId());
        }

        $app['dao.lesson']->deleteAllByChapter($idChap);
        $app['dao.chapter']->delete($idChap);

        return $app->redirect($app['url_generator']->generate('add_test_select', [
            "idClass" => $class->getId()
        ]));
    }

    /**
    * Delete lesson controller.
    *
    * @param integer $idLess lesson id
    * @param Application $app Silex application
    */
    public function deleteLessonAction($idClass, $idLess, Application $app) {
        
        $class = $app['dao.class']->find($idClass);

        $steps = $app['dao.step']->deleteAllByLesson($idLess);
        $l_tests = $app['dao.l_test']->findAllByLesson($idLess);

            foreach ($l_tests as $l_test) {
                $l_marks = $app['dao.l_mark']->deleteAllByTest($l_test->getId());
            }
        
        $app['dao.l_test']->deleteAllByLesson($idLess);
        $app['dao.lesson']->delete($idLess);

        return $app->redirect($app['url_generator']->generate('nav_sub', [
            "idClass" => $class->getId()
        ]));
    }

    /**
    * Delete step controller.
    *
    * @param integer $idstep step id
    * @param Application $app Silex application
    */
    public function deleteStepAction($idClass, $idStep, Application $app) {
        
        $class = $app['dao.class']->find($idClass);

        $steps = $app['dao.step']->delete($idStep);

        return $app->redirect($app['url_generator']->generate('add_test_select', [
            "idClass" => $class->getId()
        ]));
    }
    
    /**
    * Delete test controller.
    *
    * @param integer $idTest lesson id
    * @param Application $app Silex application
    */
    public function deleteTestAction($idClass, $idTest, Application $app) {
        
        $class = $app['dao.class']->find($idClass);

        $app['dao.l_mark']->deleteAllByTest($idTest);

        $l_test = $app['dao.l_test']->delete($idTest);

        return $app->redirect($app['url_generator']->generate('nav_sub', [
            "idClass" => $class->getId()
        ]));
    }

    /**
    * Delete programm controller.
    *
    * @param integer $id chapter id and $idProg the prog id
    * @param Application $app Silex application
    */
    public function deleteProgAction($idClass, $idProg, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $prog = $app['dao.prog']->find($idProg);
        $idPeriod = $prog->getPeriod();

        $prog = $app['dao.prog']->delete($idProg);

        return $app->redirect($app['url_generator']->generate('show_programm', [
            "idClass" => $class->getId(),
            "idPeriod" => $idPeriod
        ]));
    }
}

