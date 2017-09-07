<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Form\Type\SubjectType;
use Classy\Form\Type\ChapterType;
use Classy\Form\Type\LessonType;
use Classy\Form\Type\StepType;

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
}