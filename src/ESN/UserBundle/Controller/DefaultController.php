<?php

namespace ESN\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNUserBundle:Default:index.html.twig');
    }
}
