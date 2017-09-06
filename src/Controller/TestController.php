<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\L_Test;
use Classy\Domain\L_Mark;
use Classy\Form\Type\L_TestType;
use Classy\Form\Type\L_MarkType;
use Spipu\Html2Pdf\Html2Pdf;

class TestController {

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

             return $this->navigationAction($idClass, $request, $app);
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
     * Show test mark page controller.
     *
     * @param Application $app Silex application
     */

    public function showTestAction($idClass, $idTest,  Request $request, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $test = $app['dao.l_test']->find($idTest);
        $marks = $app['dao.l_mark']->findAllByTest($idTest);

        $markStud = array();
        $markValue = array();

        foreach ($marks as $mark) {
                array_push($markStud, $mark->getStudent()->getName());
                array_push($markValue, $mark->getValue());
        }

        return $app['twig']->render('test.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'test' => $test,
            'marks' => $marks,
            'markStud' => json_encode($markStud),
            'markValue' => json_encode($markValue)
        ));
        
    }

    /**
     * Navigation page Controller
     *
     * @param Application $app Silex application
     * @param Class $id
     */

     public function navigationAction($idClass, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($idClass);
        $chapters = $app['dao.chapter']->findAllByClass($idClass);
        $lessons = $app['dao.lesson']->findAllByClass($idClass);
        $tests = $app['dao.l_test']->findAllByClass($idClass);

            return $app['twig']->render('navigation.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'subjects' => $subjects,
                'chapters' => $chapters,
                'lessons' => $lessons,
                'tests' => $tests
            ));

        
    }

    /**
     * PDF page Controller
     *
     * @param Application $app Silex application
     * @param Class $id
     */

     public function pdfAction($idClass, $idLess, Request $request, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $lesson = $app['dao.lesson']->find($idLess);
        $chapter = $lesson->getchapter();
        $subject = $chapter->getSubject();
        $classes = $app['dao.class']->findAll();
        $steps = $app['dao.step']->findAllByLesson($idLess);

        $html = $app['twig']->render('lesson_PDF.html.twig', array(
            'lesson' => $lesson,
            'steps' => $steps,
            'subject' => $subject,
            'chapter' => $chapter
        ));

        $idPDF = 'Seance' . $class->getId() .'-'. $lesson->getId() . '.pdf' ;

        $pdf = new Html2Pdf('P', 'A4', 'fr');
        $pdf->pdf->SetDisplayMode('fullpage');
        $pdf->writeHTML($html);
        $pdf->Output($idPDF);

        
    }


}