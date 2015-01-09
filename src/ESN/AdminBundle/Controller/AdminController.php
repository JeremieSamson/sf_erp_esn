<?php

namespace ESN\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNAdminBundle::index.html.twig');
    }
    
    public function subnavbarAction()
    {
        return $this->render('ESNAdminBundle:Admin:subnavbar.html.twig');
    }
}
