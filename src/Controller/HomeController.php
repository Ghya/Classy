<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\User;
use Classy\Domain\Memo;
use Classy\Domain\Classe;
use Classy\Domain\Student;
use Classy\Domain\Subject;
use Classy\Domain\Chapter;
use Classy\Domain\Lesson;
use Classy\Domain\Step;
use Classy\Form\Type\UserType;
use Classy\Form\Type\ClasseType;
use Classy\Form\Type\StudentType;
use Classy\Form\Type\MemoType;
use Classy\Form\Type\SubjectType;
use Classy\Form\Type\ChapterType;
use Classy\Form\Type\LessonType;
use Classy\Form\Type\StepType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */

    public function homeAction(Request $request, Application $app) {

        if ($app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            return $this->boardAction($request, $app);
        } 
        elseif ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app['twig']->render('parent.html.twig');
        }         

        return $this->loginAction($request, $app);

        
    }

    /**
     * BOARD Controller.
     *
     * @param Application $app Silex application
     */

     public function boardAction(Request $request, Application $app) {
        
        $classes = $app['dao.class']->findAll();
        $memos = $app['dao.memo']->findAll();

        $memo = new Memo();
        $memoForm = $app['form.factory']->create(MemoType::class, $memo);
        $memoForm->handleRequest($request);
        $memoFormView = $memoForm->createView();

        if ($memoForm->isSubmitted() && $memoForm->isValid()) {
            $app['dao.memo']->save($memo);

                return $app->redirect($app['url_generator']->generate('board'));
        }

        $class = new Classe();
        $classForm = $app['form.factory']->create(ClasseType::class, $class);
        $classForm->handleRequest($request);
        $classFormView = $classForm->createView();

        if ($classForm->isSubmitted() && $classForm->isValid()) {
            $app['dao.class']->save($class);
            $app['session']->getFlashBag()->add('success', 'La classe a bien été crée');

                return $app->redirect($app['url_generator']->generate('board'));
        } 

        

        return $app['twig']->render('board.html.twig', array(
            'memos' => $memos,
            'classes' => $classes,
            'classForm' => $classFormView,
            'memoForm' => $memoFormView
        ));

        
    }

    /**
     * Class dashboard page controller.
     *
     * @param Classs $id and Application $app Silex application
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
     * Navigation page Controller
     *
     * @param Application $app Silex application
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
     * All Student List page controller.
     *
     * @param Application $app Silex application
     */

    public function studentListAction($id, Request $request,  Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();
        $students = $app['dao.student']->findAllByClassSimple($id);  

        return $app['twig']->render('student_list.html.twig', array(
            'class' => $class,
            'students' => $students,
            'classes' => $classes
        ));

        
    }

    /**
     * Class page controller.
     *
     * @param Application $app Silex application
     */

    public function addStudentAction($id, Request $request,  Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();

        $student = new Student();
        $student->setClass($class);
        $studentForm = $app['form.factory']->create(StudentType::class, $student);
        $studentForm->handleRequest($request);
        $studentFormView = $studentForm->createView();

        if ($studentForm->isSubmitted() && $studentForm->isValid()) {
            $app['dao.student']->save($student);

             return $app->redirect($app['url_generator']->generate('list', array(
                'id' => $class->getId()
            )));
        }   

        return $app['twig']->render('add_student.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'studentForm' => $studentFormView
        ));

        
    }

    /**
     * Class page controller.
     *
     * @param Application $app Silex application
     */

    public function studentAction($idClass, $idStud, Request $request,  Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $student = $app['dao.student']->find($idStud);


        return $app['twig']->render('student.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'student' => $student
        ));

        
    }

    /**
     * Log user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */

    public function loginAction(Request $request, Application $app) {

        return $app['twig']->render('login.html.twig', array(
            
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ));
    }

    /**
     * Sign up controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function signinAction(Request $request, Application $app) {
        $user = new User();
        $user->setRole('ROLE_USER');
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);

            return $app->redirect($app['url_generator']->generate('login', array(
                'username' => $user->getUsername(),
                'password' => $user->getPassword()
            )));

        } 

        return $app['twig']->render('user_form.html.twig', array(
            'title' => 'Inscription',
            'userForm' => $userForm->createView()));
    }
    

    /**
     * Subject management page controller.
     *
     * @param Application $app Silex application
     * @param class $id
     */

    public function subjectManagementAction($id, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($id);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($class->getId());

        $subject = new Subject();
        $subject->setClass($class);
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

            return $app['twig']->render('subject_manag.html.twig', array(
                'class' => $class,
                'subjects' => $subjects,
                'classes' => $classes,
                'subjectForm' => $subjectFormView
            ));

        
    }

    /**
     * add subject page controller.
     *
     * @param Application $app Silex application
     */

     public function selectSubjectAction($idClass, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($idClass);   

            return $app['twig']->render('select_subject.html.twig', array(
                'class' => $class,
                'subjects' => $subjects,
                'classes' => $classes
            ));

        
    }

    /**
     * New Lesson -> Add chapter page controller.
     *
     * @param Application $app Silex application
     * @param Class $id
     * @param Subject $id
     */

     public function selectChapterAction($idClass, $idSub, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $subjects = $app['dao.subject']->findAllByClass($idClass);
        $subject = $app['dao.subject']->find($idSub);
        $chapters =  $app['dao.chapter']->findAllBySubject($idSub);
        
        $chapter = new Chapter();
        $chapter->setSubject($subject);
        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        $chapterFormView = $chapterForm->createView(); 

        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);

             return $app->redirect($app['url_generator']->generate('chapter', [
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

    /**
     * add lesson page controller.
     *
     * @param Application $app Silex application
     */

    public function addLessonAction($idClass, $idSub, $idChap, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $subject = $app['dao.subject']->find($idSub);
        $chapter = $app['dao.chapter']->find($idChap);

        $classes = $app['dao.class']->findAll();

        $lesson = new Lesson();
        $lesson->setChapter($chapter);
        $lessonForm = $app['form.factory']->create(LessonType::class, $lesson);
        $lessonForm->handleRequest($request);
        $lessonFormView = $lessonForm->createView(); 

        if ($lessonForm->isSubmitted() && $lessonForm->isValid()) {
            $app['dao.lesson']->save($lesson);

            return $app->redirect($app['url_generator']->generate('add_step', [
                 "idClass" => $class->getId(),
                 "idChap" => $chapter->getId(),
                 "idLess" => $lesson->getId(),
                 "idSub" => $subject->getId()
             ]));
        }   

            return $app['twig']->render('add_lesson.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'subject' => $subject,
                'chapter' => $chapter,
                'lessonForm' => $lessonFormView
            ));

        
    }

    /**
     * ass step page controller.
     *
     * @param Application $app Silex application
     */

    public function addStepAction($idClass, $idSub, $idChap, $idLess, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $subject = $app['dao.subject']->find($idSub);
        $chapter = $app['dao.chapter']->find($idChap);
        $lesson = $app['dao.lesson']->find($idLess);
        $steps = $app['dao.step']->findAllByLessonDesc($idLess);

        $classes = $app['dao.class']->findAll();

        $step = new Step();
        $step->setLesson($lesson);
        $stepForm = $app['form.factory']->create(StepType::class, $step);
        $stepForm->handleRequest($request);
        $stepFormView = $stepForm->createView(); 

        if ($stepForm->isSubmitted() && $stepForm->isValid()) {
            $app['dao.step']->save($step);

             return $app->redirect($app['url_generator']->generate('add_step', [
                 "idClass" => $class->getId(),
                 "idChap" => $chapter->getId(),
                 "idLess" => $lesson->getId(),
                 "idSub" => $subject->getId()
             ]));
        }   

            return $app['twig']->render('add_step.html.twig', array(
                'class' => $class,
                'classes' => $classes,
                'subject' => $subject,
                'chapter' => $chapter,
                'step' => $step,
                'steps' => $steps,
                'stepForm' => $stepFormView
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
                'steps' => $steps
            ));

        
    }

    
    
}   