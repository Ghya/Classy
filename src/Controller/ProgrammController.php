<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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
    
}