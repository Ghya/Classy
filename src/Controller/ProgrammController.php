<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Classy\Form\Type\ProgType;
use Classy\Domain\Prog;

class ProgrammController {

    /**
     * programm page controller.
     *
     * @param Application $app Silex application
     * @param idClass
     */

    public function programmAction($idClass, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        return $app['twig']->render('programm.html.twig', array(
            'class' => $class,
            'classes' => $classes
        ));
        
    }

    /**
     * Show programm page controller.
     *
     * @param Application $app Silex application
     * @param idClass idPeriod
     */

    public function showProgrammAction($idClass, $idPeriod, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        $progs = $app['dao.prog']->findAllByClassAndPeriod($idClass, $idPeriod);

        return $app['twig']->render('show_programm.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'progs' => $progs,
            'period' => $idPeriod
        ));
        
    }
    /**
     * add programmation page controller.
     *
     * @param Application $app Silex application
     * @param Request $request
     * @param $idClass the class id, $idPeriod the period id
     */

    public function addProgAction($idClass, $idPeriod, Request $request, Application $app) {
        
        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();
        
        $period = $idPeriod;

        $prog = new Prog();
        $prog->setClass($class);
        $prog->setPeriod($period);
        $progForm = $app['form.factory']->create(ProgType::class, $prog);
        $progForm->handleRequest($request);
        $progFormView = $progForm->createView(); 

        if ($progForm->isSubmitted() && $progForm->isValid()) {
            $app['dao.prog']->save($prog);

            return $app->redirect($app['url_generator']->generate('show_programm', [
                "idClass" => $class->getId(),
                "idPeriod" => $period
            ]));
        }   

        return $app['twig']->render('add_prog.html.twig', array(
            'class' => $class,
            'classes' => $classes,
            'period' => $period,
            'progForm' => $progFormView
        ));

        
    }
    
}