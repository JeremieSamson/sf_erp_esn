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
        return $this->render('ESNAdministrationBundle:Countries:form.html.twig');
    }
    
     public function polesAction()
    {
        return $this->render('ESNAdministrationBundle:Poles:form.html.twig');
    }
    
     public function rulesAction()
    {
        return $this->render('ESNAdministrationBundle:Rules:form.html.twig');
    }
    
     public function tripsAction()
    {
        return $this->render('ESNAdministrationBundle:Trips:form.html.twig');
    }
    
    public function universitiesAction()
    {
        return $this->render('ESNAdministrationBundle:Universities:form.html.twig');
    }
}
