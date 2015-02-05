<?php

namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ESN\AdministrationBundle\Entity\Country;
use Symfony\Component\HttpFoundation\Request;

class AdministrationController extends Controller
{    

     public function indexAction($type, $action)
    {
        $data = array('title' => "Administration", 'type' => $type, 'action' => $action);
        return $this->render('ESNAdministrationBundle::index.html.twig', $data);
        
    }
    
     public function polesAction($action)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Pole');
                $poles = array(
                    "poles" => $repository->findAll()
                        );
        switch($action) {
            case "list" :
                return $this->render('ESNAdministrationBundle:Poles:list.html.twig', $poles);
                break;
            
            case "add" : 
                return $this->render('ESNAdministrationBundle:Poles:form.html.twig');
                break;
        } 
    }
    
     public function rulesAction($action)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Rule');
                $rules = array(
                    "rules" => $repository->findAll()
                        );
        switch($action) {
            case "list" :
                return $this->render('ESNAdministrationBundle:Rules:list.html.twig', $rules);
                break;
            
            case "add" : 
                return $this->render('ESNAdministrationBundle:Rules:form.html.twig');
                break;
        }
    }
    
     public function tripsAction($action)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:Trip');
                $trips = array(
                    "trips" => $repository->findAll()
                        );
        switch($action) {
            case "list" :
                return $this->render('ESNAdministrationBundle:Trips:list.html.twig', $trips);
                break;
            
            case "add" : 
                return $this->render('ESNAdministrationBundle:Trips:form.html.twig');
                break;
        }
    }
    
    public function universitiesAction($action)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ESNAdministrationBundle:University');
                $universities = array(
                    "universities" => $repository->findAll()
                        );
        switch($action) {
            case "list" :
                return $this->render('ESNAdministrationBundle:Universities:list.html.twig', $universities);
                break;
            
            case "add" : 
                return $this->render('ESNAdministrationBundle:Universities:form.html.twig');
                break;
        }
    }
}
