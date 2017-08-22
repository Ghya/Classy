<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\L_Test;
use Classy\Domain\L_Mark;
use Classy\Form\Type\L_TestType;
use Classy\Form\Type\L_MarkType;

class TestController {

    /**
     * Class page controller.
     *
     * @param Application $app Silex application
     */

    public function classAction($id, Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();
        $students = $app['dao.student']->findAllByClass($id);    

            return $app['twig']->render('class.html.twig', array(
                'class' => $class,
                'students' => $students,
                'classes' => $classes,
            ));

        
    }

    /**
     * select to add test page controller.
     *
     * @param Application $app Silex application
     */

    public function addTestSelectAction($idClass, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $lessons = $app['dao.lesson']->findAllByClass($idClass);

            return $app['twig']->render('add_test_select.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'lessons' => $lessons
            ));

        
    }

    /**
     * add subject page controller.
     *
     * @param Application $app Silex application
     */

    public function addL_TestAction($idClass, $idLess, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $lesson = $app['dao.lesson']->find($idLess);
        $students = $app['dao.student']->findAllByClass($idClass);

        $test = new L_Test();
        $test->setLesson($lesson);

        foreach ($students as $student) {
            $mark = new L_Mark();
            $mark->setStudent($student);
            $test->getMarks()->add($mark);
        }

        $l_markForm = $app['form.factory']->create(L_TestType::class, $test);

        $l_markForm->handleRequest($request);

        $l_markFormView = $l_markForm->createView(); 

        if ($l_markForm->isSubmitted() && $l_markForm->isValid()) {
            $app['dao.l_test']->saveTestMarks($test, $test->getMarks());            

             return $this->classAction($idClass, $app);
        }

            return $app['twig']->render('add_marks.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'test' => $test,
                'students' => $students,
                'form' => $l_markFormView
            ));

        
    }

    /**
     * select page controller.
     *
     * @param Application $app Silex application
     */

    public function selectTestAction($id, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();
        $tests = $app['dao.l_test']->findAllByClass($id);


            return $app['twig']->render('select_test.html.twig', array(
                'class' => $class,
                'tests' => $tests,
                'classes' => $classes
            ));

        
    }

    /**
     * Show test mark page controller.
     *
     * @param Application $app Silex application
     */

    public function showTestAction($idClass, $idTest,  Request $request, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $test = $app['dao.l_test']->find($idTest);
        $marks = $app['dao.l_mark']->findAllByTest($idTest);


            return $app['twig']->render('test.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'test' => $test,
                'marks' => $marks
            ));

        
    }

}