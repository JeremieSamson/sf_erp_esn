<?php

namespace ESN\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNLoginBundle:Default:index.html.twig');
    }
}
