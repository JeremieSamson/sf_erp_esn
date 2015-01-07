<?php

namespace ESN\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNAdminBundle:Default:index.html.twig');
    }
}
