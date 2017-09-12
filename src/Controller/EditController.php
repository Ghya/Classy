<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Form\Type\SubjectType;
use Classy\Form\Type\ChapterType;
use Classy\Form\Type\LessonType;
use Classy\Form\Type\StudentType;
use Classy\Form\Type\StepType;
use Classy\Form\Type\ProgType;
use Classy\Form\Type\L_TestType;

class EditController {
    /**
     * Edit subject page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass, $idSub
     */

    public function editSubjectAction($idClass, $idSub, Request $request, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        $subject = $app['dao.subject']->find($idSub);

        $subjectForm = $app['form.factory']->create(SubjectType::class, $subject);
        $subjectForm->handleRequest($request);
        $subjectFormView = $subjectForm->createView(); 

        if ($subjectForm->isSubmitted() && $subjectForm->isValid()) {
            $app['dao.subject']->save($subject);
            $app['session']->getFlashBag()->add('success', 'Votre memo a été ajouté');

            return $app->redirect($app['url_generator']->generate('sub_manag', [
                "id" => $class->getId()
            ]));
        }   

        return $app['twig']->render('edit_subject.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'subject' => $subject,
            'subjectForm' => $subjectFormView
        ));
        
    }

    /**
     * Edit chapter page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass, $idChap, $idSub
     */

     public function editChapterAction($idClass, $idSub, $idChap, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($idClass);
        $chapters = $app['dao.chapter']->findAllByClass($idClass);
        $lessons = $app['dao.lesson']->findAllByClass($idClass);
        $tests = $app['dao.l_test']->findAllByClass($idClass);

        $subject = $app['dao.subject']->find($idSub);
        $chapter = $app['dao.chapter']->find($idChap);

        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        $chapterFormView = $chapterForm->createView(); 

        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);

            return $app->redirect($app['url_generator']->generate('navigation', [
                "idClass" => $class->getId()
            ]));
        }      

        return $app['twig']->render('edit_chapter.html.twig', array(
            'class' => $class,
            'subject' => $subject,
            'classes' => $classes,
            'chapter' => $chapter,
            'chapterForm' => $chapterFormView
        ));
        
    }

    /**
     * Edit lesson page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass, $idSub, $idChap $idLess
     */

    public function editLessonAction($idClass, $idLess, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        $lesson = $app['dao.lesson']->find($idLess);

        $lessonForm = $app['form.factory']->create(LessonType::class, $lesson);
        $lessonForm->handleRequest($request);
        $lessonFormView = $lessonForm->createView(); 

        if ($lessonForm->isSubmitted() && $lessonForm->isValid()) {
            $app['dao.lesson']->save($lesson);
            $app['session']->getFlashBag()->add('success', 'Votre memo a été ajouté');

            return $app->redirect($app['url_generator']->generate('lesson', [
                "idClass" => $class->getId(),
                "idLess" => $lesson->getId()
            ]));
        }   

        return $app['twig']->render('edit_lesson.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'lesson' => $lesson,
            'lessonForm' => $lessonFormView
        ));
        
    }

    /**
     * Edit lesson page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass, $idSub, $idChap $idLess
     */

     public function editStepAction($idClass, $idLess, $idStep, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        $lesson = $app['dao.lesson']->find($idLess);

        $step = $app['dao.step']->find($idStep);
        $steps = $app['dao.step']->findAllByLessonDesc($idLess); 

        $stepForm = $app['form.factory']->create(StepType::class, $step);
        $stepForm->handleRequest($request);
        $stepFormView = $stepForm->createView(); 

        if ($stepForm->isSubmitted() && $stepForm->isValid()) {
            $app['dao.step']->save($step);

             return $app->redirect($app['url_generator']->generate('lesson', [
                "idClass" => $class->getId(),
                "idLess" => $lesson->getId()
             ]));
        }   

        return $app['twig']->render('edit_step.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'step' => $step,
            'steps' => $steps,
            'stepForm' => $stepFormView
        ));
        
    }

    /**
     * Edit subject page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass, $idSub
     */

     public function editProgAction($idClass, $idProg, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        $prog = $app['dao.prog']->find($idProg);

        $progForm = $app['form.factory']->create(ProgType::class, $prog);
        $progForm->handleRequest($request);
        $progFormView = $progForm->createView(); 

        if ($progForm->isSubmitted() && $progForm->isValid()) {
            $app['dao.prog']->save($prog);
            $app['session']->getFlashBag()->add('success', 'Votre programmation a été ajouté');

            return $app->redirect($app['url_generator']->generate('show_programm', [
                "idClass" => $class->getId(),
                "idPeriod" => $prog->getPeriod()
            ]));
        }   

        return $app['twig']->render('edit_prog.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'prog' => $prog,
            'progForm' => $progFormView
        ));
        
    }

    /**
     * add subject page controller.
     *
     * @param Application $app Silex application
     */

     public function editTestAction($idClass, $idTest, $idLess, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $lesson = $app['dao.lesson']->find($idLess);
        $students = $app['dao.student']->findAllByClass($idClass);



        $test = $app['dao.l_test']->find($idTest);



        $marks = $app['dao.l_mark']->findAllByTest($idTest);
        foreach ($marks as $mark) {
            $test->getMarks()->add($mark);
        }
        

        $l_markForm = $app['form.factory']->create(L_TestType::class, $test);

        $l_markForm->handleRequest($request);

        $l_markFormView = $l_markForm->createView(); 

        if ($l_markForm->isSubmitted() && $l_markForm->isValid()) {
            $app['dao.l_test']->saveTestMarks($test, $test->getMarks());            

            return $app->redirect($app['url_generator']->generate('test', [
                "idClass" => $idClass,
                "idTest" => $idTest
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
     * Edit student page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param idClass stud id
     * @param idStud stud id
     */

     public function editStudentAction($idClass, $idStud, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        $student = $app['dao.student']->find($idStud);

        $studentForm = $app['form.factory']->create(StudentType::class, $student);
        $studentForm->handleRequest($request);
        $studentFormView = $studentForm->createView(); 

        if ($studentForm->isSubmitted() && $studentForm->isValid()) {
            $app['dao.student']->save($student);

             return $app->redirect($app['url_generator']->generate('student', [
                "idClass" => $class->getId(),
                "idStud" => $student->getId()
             ]));
        }   

        return $app['twig']->render('edit_student.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'student' => $student,
            'studentForm' => $studentFormView
        ));
        
    }
}