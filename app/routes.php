<?php

// Home page
$app->match('/', "Classy\Controller\HomeController::homeAction")
->bind('home');

// Log in form
$app->get('/login', "Classy\Controller\HomeController::loginAction")
->bind('login');

// Board
$app->match('/board', "Classy\Controller\HomeController::boardAction")
->bind('board');

// Sign in form
$app->match('/signin', "Classy\Controller\HomeController::signinAction")
->bind('signin');

// Class details
$app->match('/class/{id}', "Classy\Controller\HomeController::classAction")
->bind('class');

// Student List
$app->match('/class/{id}/list', "Classy\Controller\HomeController::studentListAction")
->bind('list');

// Add Student
$app->match('/class/{id}/add_student', "Classy\Controller\HomeController::addStudentAction")
->bind('add_student');

// Add Student
$app->match('/class/{idClass}/student/{idStud}', "Classy\Controller\HomeController::studentAction")
->bind('student');

// Subject
$app->match('/class/{id}/lessons', "Classy\Controller\SelectLessonController::subjectAction")
->bind('lessons');

// Lesson
$app->match('/class/{idClass}/lessons/{idLess}', "Classy\Controller\SelectLessonController::lessonAction")
->bind('lesson');

// Add Subject
$app->match('/class/{id}/subject', "Classy\Controller\HomeController::addSubjectAction")
->bind('add_subject');

// Add Chapter
$app->match('/class/{idClass}/subject/{idSub}/chapter', "Classy\Controller\HomeController::addChapterAction")
->bind('add_chapter');

// Add Lesson
$app->match('/class/{idClass}/subject/{idSub}/chapter/{idChap}/add_lesson', "Classy\Controller\HomeController::addLessonAction")
->bind('add_lesson');

// Add Step
$app->match('/class/{idClass}/subject/{idSub}/chapter/{idChap}/lesson/{idLess}/add_step', "Classy\Controller\HomeController::addStepAction")
->bind('add_step');

// Add test select
$app->match('/class/{idClass}/add_test_select', "Classy\Controller\TestController::addTestSelectAction")
->bind('add_test_select');

// Add L_test
$app->match('/class/{idClass}/lesson/{idLess}/test', "Classy\Controller\TestController::addL_TestAction")
->bind('add_test');

// Show test select
$app->match('/class/{id}/test_select', "Classy\Controller\TestController::selectTestAction")
->bind('select_test');

// Show test 
$app->match('/class/{idClass}/test/{idTest}/show_test', "Classy\Controller\TestController::showTestAction")
->bind('test');