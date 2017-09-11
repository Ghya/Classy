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

            return $app->redirect($app['url_generator']->generate('test', [
                "idClass" => $class->getId(),
                "idTest" => $test->getId()
            ]));
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
        $marksASC = $app['dao.l_mark']->findAllByTestASC($idTest);

        $markStud = array();
        $markValue = array();

        foreach ($marksASC as $markASC) {
                array_push($markStud, $markASC->getStudent()->getName());
                array_push($markValue, $markASC->getValue());
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

    /**
     * Show test mark page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param class id $idclass
     */

     public function statTestAction($idClass,  Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $tests = $app['dao.l_test']->findAllByClass($idClass);

        $classAvg = array();
        $classDate = array();
        $avgPlus = 0;
        $avgMinus = 0;
        
        foreach ($tests as $test) {
            array_push($classAvg, $test->getClassAvg());
            array_push($classDate, $test->getDate());
                
            
            if ($test->getAverage() >= 5) {
                $avgPlus ++;
            } else {
                $avgMinus ++;
            }
            
        }

        $testNbr = count($test);

        $stats = $app['dao.l_test']->avgDateTest($idClass);

        $testAvg = array();
        $testDate = array();
        
        foreach ($stats as $stat) {
            array_push($testDate, $stat->getName());
            array_push($testAvg, $stat->getAverage());
        }

        return $app['twig']->render('stat_board.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'testAvg' => json_encode($testAvg),
            'testDate' => json_encode($testDate),
            'classAvg' => json_encode($classAvg),
            'classDate' => json_encode($classDate),
            'avgPlus' => $avgPlus,
            'avgMinus' => $avgMinus
        ));
        
    }

    /**
     * Show class stat page controller.
     *
     * @param Application $app Silex application
     */

     public function statClassAction($idClass,  Request $request, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $students = $app['dao.student']->findAllByClass($idClass);
        $subjects = $app['dao.subject']->findAllByClass($idClass);
        $lesson = $app['dao.lesson']->count($idClass);
        $test = $app['dao.l_test']->count($idClass);
        $avg = $app['dao.l_test']->avg($idClass);
        $avgRounded = round($avg, 2);

        $boy = 0;
        $girl = 0;

        foreach ($students as $student) {
            if ($student->getGender() == 1) {
                $boy ++;
            } else {
                $girl ++;
            }
        };

        return $app['twig']->render('stat_class.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'students' => $students,
            'lesson' => $lesson,
            'test' => $test,
            'avg' => $avgRounded,
            'subjects' => $subjects,
            'boy' => $boy,
            'girl' => $girl
        ));
        
    }


}