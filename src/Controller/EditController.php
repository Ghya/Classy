<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Form\Type\SubjectType;
use Classy\Form\Type\ChapterType;

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

            return $app->redirect($app['url_generator']->generate('add_subject', [
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

        $chapter = $app['dao.subject']->find($idChap);

        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        $chapterFormView = $chapterForm->createView(); 

        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);

            return $app->redirect($app['url_generator']->generate('add_chapter', [
                "idClass" => $class->getId(),
                "idSub" => $subject->getId()
            ]));
        }      

        return $app['twig']->render('select_chapter.html.twig', array(
            'class' => $class,
            'subjects' => $subjects,
            'subject' => $subject,
            'classes' => $classes,
            'chapters' => $chapters,
            'chapterForm' => $chapterFormView
        ));
        
    }
}