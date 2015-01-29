<?php

namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdministrationController extends Controller
{
    public function indexAction($type)
    {
        $data = array('title' => "Administration", 'type' => $type);
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
    public function countriesAction()
    {
        return $this->render('ESNAdministrationBundle:Countries:index.html.twig');
    }
    
     public function polesAction()
    {
        return $this->render('ESNAdministrationBundle:Poles:index.html.twig');
    }
    
     public function rulesAction()
    {
        return $this->render('ESNAdministrationBundle:Rules:index.html.twig');
    }
    
     public function tripsAction()
    {
        return $this->render('ESNAdministrationBundle:Trips:index.html.twig');
    }
    
    public function universitiesAction()
    {
        return $this->render('ESNAdministrationBundle:Universities:index.html.twig');
    }
}
