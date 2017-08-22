<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Domain\Chapter;
use Classy\Domain\User;
use Classy\Form\Type\ChapterType;
use Classy\Form\Type\CommentType;
use Classy\Form\Type\UserTypeAdmin;

class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $chapters = $app['dao.chapter']->findAll();
        $lastChapter = $app['dao.chapter']->findLast();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin2.html.twig', array(
            'chapters' => $chapters,
            'comments' => $comments,
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'users' => $users));
    }

    /**
     * Show comment by chapter
     *
     * @param chapter id
     */
    public function commentByChapterAction($id, Application $app) {
        $comments = $app['dao.comment']->findAllByChapter($id);
        $chapter = $app['dao.chapter']->find($id);
        $lastChapter = $app['dao.chapter']->findLast();

        return $app['twig']->render('comment_by_chapter.html.twig', array(
                'comments' => $comments,
                'lastChapter' => $lastChapter,
                'marker' => $_COOKIE['marker'],
                'chapter' => $chapter
            ));
    }

    /**
     * Add chapter controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addChapterAction(Request $request, Application $app) {
        $lastChapter = $app['dao.chapter']->findLast();
        $chapter = new Chapter();
        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);
            $app['session']->getFlashBag()->add('success', 'Le chapitre a bien été créé');

            return $app->redirect($app['url_generator']->generate('admin'));
        }

        return $app['twig']->render('chapter_form.html.twig', array(
            'title' => 'New chapter',
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'chapterForm' => $chapterForm->createView()));
    }

    /**
     * Edit chapter controller.
     *
     * @param integer $id chapter id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editChapterAction($id, Request $request, Application $app) {
        $lastChapter = $app['dao.chapter']->findLast();
        $chapter = $app['dao.chapter']->find($id);
        $chapterForm = $app['form.factory']->create(ChapterType::class, $chapter);
        $chapterForm->handleRequest($request);
        if ($chapterForm->isSubmitted() && $chapterForm->isValid()) {
            $app['dao.chapter']->save($chapter);
            $app['session']->getFlashBag()->add('success', 'Le chapitre à été mis à jour.');
        }
        return $app['twig']->render('chapter_form.html.twig', array(
            'title' => 'Edit chapter',
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'chapterForm' => $chapterForm->createView()));
    }

    /**
     * Delete chapter controller.
     *
     * @param integer $id chapter id
     * @param Application $app Silex application
     */
    public function deleteChapterAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByChapter($id);
        // Delete the chapter
        $app['dao.chapter']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le chapitre a été supprimé.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editCommentAction($id, Request $request, Application $app) {
        $lastChapter = $app['dao.chapter']->findLast();
        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Le commentaire à bien été mis à jour.');
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'title' => 'Modifier un commentaire',
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'commentForm' => $commentForm->createView()));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function deleteCommentAction($id, Application $app) {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire à bien été supprimé.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addUserAction(Request $request, Application $app) {
        $lastChapter = $app['dao.chapter']->findLast();
        $user = new User();
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
            $app['session']->getFlashBag()->add('success', 'L\'utilisateur à bien été créé.');
        }
        return $app['twig']->render('user_form_admin.html.twig', array(
            'title' => 'Nouvel utilisateur',
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'userForm' => $userForm->createView()));
    }

    /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editUserAction($id, Request $request, Application $app) {
        $lastChapter = $app['dao.chapter']->findLast();
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserTypeAdmin::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $plainPassword = $user->getPassword();
            // find the encoder for the user
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password); 
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'Les données de l\'utilisteur ont bien été mis à jour.');
        }
        return $app['twig']->render('user_form_admin.html.twig', array(
            'title' => "Gestionnaire d'utilisateur",
            'lastChapter' => $lastChapter,
            'marker' => $_COOKIE['marker'],
            'userForm' => $userForm->createView()));
    }

    /**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
    public function deleteUserAction($id, Application $app) {
        // Delete all associated comments
        $app['dao.comment']->deleteAllByUser($id);
        // Delete the user
        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'utilisateur à bien été supprimé.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('admin'));
    }

}