<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\Chapter;
use Classy\Domain\User;
use Classy\Form\Type\ChapterType;
use Classy\Form\Type\CommentType;
use Classy\Form\Type\UserTypeAdmin;

class SelectLessonController {

    /**
     * Subject page controller.
     *
     * @param Application $app Silex application
     */

    public function subjectAction($id, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($id);
        $lessons = $app['dao.lesson']->findAllByClass($id);


            return $app['twig']->render('subject.html.twig', array(
                'class' => $class,
                'subjects' => $subjects,
                'lessons' => $lessons,
                'classes' => $classes
            ));

        
    }

    /**
     * Lesson page controller.
     *
     * @param Application $app Silex application
     */

    public function lessonAction($idClass, $idLess,  Request $request, Application $app) {

        $lesson = $app['dao.lesson']->find($idLess);
        $chapter = $lesson->getchapter();
        $subject = $chapter->getSubject();
        $class = $subject->getClass();
        $classes = $app['dao.class']->findAll();
        $steps = $app['dao.step']->findAllByLesson($idLess);


            return $app['twig']->render('lesson.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'subject' => $subject,
                'lesson' => $lesson,
                'chapter' => $chapter,
                'steps' => $steps,
            ));

        
    }

}