<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StefDagVanDeWeekBundle:Default:index.html.twig', array('name' => $name));
    }
}
