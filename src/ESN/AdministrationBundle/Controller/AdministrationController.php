<?php

namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdministrationController extends Controller
{
    public function indexAction()
    {
        return $this->render('ESNAdministrationBundle::index.html.twig', array(
            'title' => "Administration"
        ));
    }
    
    public function adminAction()
    {
        return $this->render('ESNAdministrationBundle:Administration:admin.html.twig');
    }
}
