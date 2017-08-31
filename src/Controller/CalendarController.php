<?php

namespace Classy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class CalendarController {
    /**
     * calendar page controller.
     *
     * @param Application $app Silex application
     * @param idClass
     */

    public function calendarAction($idClass, Application $app) {

        $class = $app['dao.class']->find($idClass);
        $classes = $app['dao.class']->findAll();

        return $app['twig']->render('calendar.html.twig', array(
            'class' => $class,
            'classes' => $classes
        ));
        
    }
}