<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// =================================================

// Register global error and exception handlers

// =================================================


ErrorHandler::register();
ExceptionHandler::register();


// =================================================

// Register service providers

// =================================================


$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new Classy\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

// =================================================

// Register services DAO

// =================================================

$app['dao.user'] = function ($app) {
    return new Classy\DAO\UserDAO($app['db']);
};

$app['dao.memo'] = function ($app) {
    return new Classy\DAO\MemoDAO($app['db']);
};

$app['dao.class'] = function ($app) {
    return new Classy\DAO\ClasseDAO($app['db']);
};

$app['dao.subject'] = function ($app) {
    $subjectDAO = new Classy\DAO\SubjectDAO($app['db']);
    $subjectDAO->setClassDAO($app['dao.class']);
    return $subjectDAO;
};

$app['dao.chapter'] = function ($app) {
    $chapterDAO = new Classy\DAO\ChapterDAO($app['db']);
    $chapterDAO->setSubjectDAO($app['dao.subject']);
    return $chapterDAO;
};

$app['dao.lesson'] = function ($app) {
    $lessonDAO = new Classy\DAO\LessonDAO($app['db']);
    $lessonDAO->setChapterDAO($app['dao.chapter']);
    return $lessonDAO;
};

$app['dao.step'] = function ($app) {
    $stepDAO = new Classy\DAO\StepDAO($app['db']);
    $stepDAO->setLessonDAO($app['dao.lesson']);
    return $stepDAO;
};

$app['dao.student'] = function ($app) {
    $studentDAO = new Classy\DAO\StudentDAO($app['db']);
    $studentDAO->setClassDAO($app['dao.class']);
    return $studentDAO;
};

$app['dao.l_test'] = function ($app) {
    $l_testDAO = new Classy\DAO\L_TestDAO($app['db']);
    $l_testDAO->setLessonDAO($app['dao.lesson']);
    return $l_testDAO;
};

$app['dao.l_mark'] = function ($app) {
    $l_markDAO = new Classy\DAO\L_MarkDAO($app['db']);
    $l_markDAO->setStudentDAO($app['dao.student']);
    return $l_markDAO;
};