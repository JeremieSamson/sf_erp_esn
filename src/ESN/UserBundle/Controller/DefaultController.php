<?php

namespace ESN\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ESNUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
