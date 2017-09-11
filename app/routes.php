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

// Lesson
$app->match('/class/{idClass}/lessons/{idLess}', "Classy\Controller\HomeController::lessonAction")
->bind('lesson');

// Subject Management
$app->match('/class/{id}/subject', "Classy\Controller\HomeController::subjectManagementAction")
->bind('sub_manag');

// Select Subject
$app->match('/class/{idClass}/subject/new_lesson', "Classy\Controller\HomeController::selectSubjectAction")
->bind('new_lesson');

// Select Chapter
$app->match('/class/{idClass}/subject/{idSub}/new_lesson', "Classy\Controller\HomeController::selectChapterAction")
->bind('chapter');

// Add Lesson
$app->match('/class/{idClass}/subject/{idSub}/chapter/{idChap}/add_lesson', "Classy\Controller\HomeController::addLessonAction")
->bind('add_lesson');

// Add Step
$app->match('/class/{idClass}/subject/{idSub}/chapter/{idChap}/lesson/{idLess}/add_step', "Classy\Controller\HomeController::addStepAction")
->bind('add_step');

// Navigation
$app->match('/class/{idClass}/add_test_select', "Classy\Controller\HomeController::navigationAction")
->bind('navigation');

// Add L_test
$app->match('/class/{idClass}/lesson/{idLess}/test', "Classy\Controller\TestController::addL_TestAction")
->bind('add_test');

// Show test select
$app->match('/class/{id}/test_select', "Classy\Controller\TestController::selectTestAction")
->bind('select_test');

// Show l_test 
$app->match('/class/{idClass}/test/{idTest}/show_test', "Classy\Controller\TestController::showTestAction")
->bind('test');

// Calendar 
$app->match('/class/{idClass}/calendar', "Classy\Controller\CalendarController::calendarAction")
->bind('calendar');


//===============================
//      Route for Programm
//===============================

// Programm 
$app->match('/class/{idClass}/programm', "Classy\Controller\ProgrammController::programmAction")
->bind('programm');

// Show Programm 
$app->match('/class/{idClass}/programm/{idPeriod}/periode', "Classy\Controller\ProgrammController::ShowProgrammAction")
->bind('show_programm');

// Show Programm 
$app->match('/class/{idClass}/programm/{idPeriod}/periode/add_new', "Classy\Controller\ProgrammController::addProgAction")
->bind('add_prog');


//===============================
//      Route for PDF
//===============================

// Lesson PDF
$app->match('/class/{idClass}/pdf/{idLess}', "Classy\Controller\TestController::pdfAction")
->bind('lesson_PDF');


//===============================
//      Route for delete
//===============================

// Delete Sub
$app->match('/class/{idClass}/subject/{idSub}', "Classy\Controller\DeleteController::deleteSubjectAction")
->bind('delete_sub');

// Delete Chap
$app->match('/class/{idClass}/chapter/{idChap}', "Classy\Controller\DeleteController::deleteChapterAction")
->bind('delete_chap');

// Delete Lesson
$app->match('/class/{idClass}/lesson/{idLess}', "Classy\Controller\DeleteController::deleteLessonAction")
->bind('delete_lesson');

// Delete Step
$app->match('/class/{idClass}/step/{idStep}', "Classy\Controller\DeleteController::deleteStepAction")
->bind('delete_step');

// Delete Test
$app->match('/class/{idClass}/subject/{idTest}', "Classy\Controller\DeleteController::deleteL_TestAction")
->bind('delete_test');

// Delete Programm
$app->match('/class/{idClass}/programm/{idProg}', "Classy\Controller\DeleteController::deleteProgAction")
->bind('delete_prog');

// Delete test
$app->match('/class/{idClass}/test/{idTest}', "Classy\Controller\DeleteController::deleteTestAction")
->bind('delete_test');


//===============================
//      Route for edit
//===============================

// Edit Sub
$app->match('/class/{idClass}/subject/{idSub}/edit', "Classy\Controller\EditController::editSubjectAction")
->bind('edit_sub');

// Edit chap
$app->match('/class/{idClass}/subject/{idSub}/chapter/{idChap}/edit', "Classy\Controller\EditController::editChapterAction")
->bind('edit_chap');

// Edit Lesson
$app->match('/class/{idClass}/lesson/{idLess}/edit', "Classy\Controller\EditController::editLessonAction")
->bind('edit_less');

// Edit Step
$app->match('/class/{idClass}/lesson/{idLess}/step/{idStep}/edit', "Classy\Controller\EditController::editStepAction")
->bind('edit_step');

// Edit Programm
$app->match('/class/{idClass}/programm/{idProg}/edit', "Classy\Controller\EditController::editProgAction")
->bind('edit_prog');

// Edit test mark
$app->match('/class/{idClass}/test/{idLess}/{idTest}/edit', "Classy\Controller\EditController::editTestAction")
->bind('edit_test');

//=========================================
//      Route for class evaluation
//=========================================

// Class test stat 
$app->match('/class/{idClass}/stat', "Classy\Controller\TestController::statTestAction")
->bind('test_stat');

// Class stat 
$app->match('/class/{idClass}/stat/class', "Classy\Controller\TestController::statClassAction")
->bind('class_stat');



